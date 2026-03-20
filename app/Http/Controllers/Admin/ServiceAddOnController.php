<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ServiceAddOn;
use App\Service;

class ServiceAddOnController extends Base
{
    public function allAddons()
    {
        $addons = ServiceAddOn::with('service')->orderBy('id', 'desc')->get();
        $services = Service::where('is_active', 1)->orderBy('service_name', 'asc')->get();

        return view('admin.service_add_ons.all', compact('addons', 'services'));
    }

    public function create()
    {
        $services = Service::where('is_active', 1)->orderBy('service_name', 'asc')->get();

        return view('admin.service_add_ons.create', compact('services'));
    }

    public function index($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $addons = ServiceAddOn::where('service_id', $serviceId)->ordered()->get();

        return view('admin.service_add_ons.index', compact('service', 'addons'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'service_id' => 'required|exists:services,id',
            'addon_name' => 'required|string|max:255',
            'addon_price' => 'required|numeric|min:0',
            'addon_description' => 'nullable|string',
            'addon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $addon = new ServiceAddOn();
        $addon->service_id = $request->service_id;
        $addon->addon_name = $request->addon_name;
        $addon->addon_price = $request->addon_price;
        $addon->addon_description = $request->addon_description;

        if ($request->hasFile('addon_image')) {
            $file = $request->file('addon_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/addons'), $filename);
            $addon->addon_image = $filename;
        }

        $addon->save();

        flash(__('Maliyet başarıyla eklendi!'))->success();

        return redirect()->route('admin.service-add-ons.index', $request->service_id);
    }

    public function edit($id)
    {
        $addon = ServiceAddOn::findOrFail($id);
        $service = $addon->service;

        return view('admin.service_add_ons.edit', compact('addon', 'service'));
    }

    public function update(Request $request, $id)
    {
        $addon = ServiceAddOn::findOrFail($id);

        $this->validate($request, [
            'addon_name' => 'required|string|max:255',
            'addon_price' => 'required|numeric|min:0',
            'addon_description' => 'nullable|string',
            'addon_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $addon->addon_name = $request->addon_name;
        $addon->addon_price = $request->addon_price;
        $addon->addon_description = $request->addon_description;

        if ($request->hasFile('addon_image')) {
            if ($addon->addon_image && file_exists(public_path('uploads/addons/' . $addon->addon_image))) {
                unlink(public_path('uploads/addons/' . $addon->addon_image));
            }

            $file = $request->file('addon_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/addons'), $filename);
            $addon->addon_image = $filename;
        }

        $addon->save();

        flash(__('Ek hizmet başarıyla güncellendi!'))->success();

        return redirect()->route('admin.service-add-ons.index', $addon->service_id);
    }

    public function destroy($id)
    {
        $addon = ServiceAddOn::findOrFail($id);
        $serviceId = $addon->service_id;

        if ($addon->addon_image && file_exists(public_path('uploads/addons/' . $addon->addon_image))) {
            unlink(public_path('uploads/addons/' . $addon->addon_image));
        }

        $addon->delete();

        return response()->json([
            'success' => true,
            'message' => __('Ek hizmet başarıyla silindi!')
        ]);
    }
}







