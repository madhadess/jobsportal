<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Service;
use App\ServiceCategory;
use Illuminate\Support\Str;

class ServiceController extends Base
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'service');
        $services = Service::whereHas('category', function ($q) use ($type) {
            $q->where('type', $type);
        })->with('category')->orderBy('sort_order', 'asc')->get();
        $categories = ServiceCategory::where('type', $type)->active()->ordered()->get();
        return view('admin.services.index', compact('services', 'categories', 'type'));
    }

    public function create(Request $request)
    {
        $type = $request->input('type', 'service');
        $categories = ServiceCategory::where('type', $type)->active()->ordered()->get();
        return view('admin.services.create', compact('categories', 'type'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:service_categories,id',
            'service_name' => 'required|max:255',
            'service_desc' => 'required',
            'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'nullable|numeric|min:0',
            'price_model' => 'required|in:fixed,hourly,package',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ], [
            'category_id.required' => __('Lütfen bir kategori seçin.'),
            'category_id.exists' => __('Seçilen kategori geçersiz.'),
            'service_name.required' => __('Hizmet adı zorunludur.'),
            'service_desc.required' => __('Hizmet açıklaması zorunludur.'),
            'service_image.image' => __('Sadece görsel dosyaları yüklenebilir.'),
            'service_image.mimes' => __('Görsel formatı jpeg, png, jpg veya gif olmalıdır.'),
            'service_image.max' => __('Görsel boyutu maksimum 2MB olabilir.'),
            'price.numeric' => __('Fiyat sayısal bir değer olmalıdır.'),
            'price.min' => __('Fiyat negatif olamaz.'),
            'price_model.required' => __('Fiyatlandırma modeli zorunludur.'),
            'price_model.in' => __('Geçersiz fiyatlandırma modeli.'),
            'duration_minutes.integer' => __('Süre tam sayı olmalıdır.'),
            'duration_minutes.min' => __('Süre negatif olamaz.'),
        ]);

        $service = new Service();
        $service->category_id = $request->category_id;
        $service->service_name = $request->service_name;
        $service->service_slug = Str::slug($request->service_name, '-');
        $service->service_desc = $request->service_desc;
        $service->price = $request->price;
        $service->price_model = $request->price_model;
        $service->duration_minutes = $request->duration_minutes;
        $service->is_active = $request->is_active;
        $service->is_featured = $request->is_featured ?? 0;
        $service->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('service_image')) {
            $image = $request->file('service_image');
            $imageName = time() . '_' . Str::slug($request->service_name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/services'), $imageName);
            $service->service_image = $imageName;
        }

        $service->save();

        flash(__('Servis başarıyla eklendi!'))->success();

        $category = ServiceCategory::find($request->category_id);
        return redirect()->route('admin.services.index', ['type' => $category->type]);
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $type = $service->category->type;
        $categories = ServiceCategory::where('type', $type)->active()->ordered()->get();
        return view('admin.services.edit', compact('service', 'categories', 'type'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'required|exists:service_categories,id',
            'service_name' => 'required|max:255',
            'service_desc' => 'required',
            'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'nullable|numeric|min:0',
            'price_model' => 'required|in:fixed,hourly,package',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer'
        ], [
            'category_id.required' => __('Lütfen bir kategori seçin.'),
            'category_id.exists' => __('Seçilen kategori geçersiz.'),
            'service_name.required' => __('Hizmet adı zorunludur.'),
            'service_desc.required' => __('Hizmet açıklaması zorunludur.'),
            'service_image.image' => __('Sadece görsel dosyaları yüklenebilir.'),
            'service_image.mimes' => __('Görsel formatı jpeg, png, jpg veya gif olmalıdır.'),
            'service_image.max' => __('Görsel boyutu maksimum 2MB olabilir.'),
            'price.numeric' => __('Fiyat sayısal bir değer olmalıdır.'),
            'price.min' => __('Fiyat negatif olamaz.'),
            'price_model.required' => __('Fiyatlandırma modeli zorunludur.'),
            'price_model.in' => __('Geçersiz fiyatlandırma modeli.'),
            'duration_minutes.integer' => __('Süre tam sayı olmalıdır.'),
            'duration_minutes.min' => __('Süre negatif olamaz.'),
        ]);

        $service = Service::findOrFail($id);
        $service->category_id = $request->category_id;
        $service->service_name = $request->service_name;
        $service->service_slug = Str::slug($request->service_name, '-');
        $service->service_desc = $request->service_desc;
        $service->price = $request->price;
        $service->price_model = $request->price_model;
        $service->duration_minutes = $request->duration_minutes;
        $service->is_active = $request->is_active;
        $service->is_featured = $request->is_featured ?? 0;
        $service->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('service_image')) {
            if ($service->service_image && file_exists(public_path('uploads/services/' . $service->service_image))) {
                unlink(public_path('uploads/services/' . $service->service_image));
            }

            $image = $request->file('service_image');
            $imageName = time() . '_' . Str::slug($request->service_name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/services'), $imageName);
            $service->service_image = $imageName;
        }

        $service->save();

        flash(__('Servis başarıyla güncellendi!'))->success();

        return redirect()->route('admin.services.index', ['type' => $service->category->type]);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->service_image && file_exists(public_path('uploads/services/' . $service->service_image))) {
            unlink(public_path('uploads/services/' . $service->service_image));
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => __('Hizmet başarıyla silindi!')
        ]);
    }

    public function toggleStatus($id)
    {
        $service = Service::findOrFail($id);
        $service->is_active = !$service->is_active;
        $service->save();

        return response()->json([
            'success' => true,
            'is_active' => $service->is_active,
            'message' => $service->is_active ? __('Hizmet aktif edildi!') : __('Hizmet pasif edildi!')
        ]);
    }

    public function toggleFeatured($id)
    {
        $service = Service::findOrFail($id);
        $service->is_featured = !$service->is_featured;
        $service->save();

        return response()->json([
            'success' => true,
            'is_featured' => $service->is_featured,
            'message' => $service->is_featured ? __('Hizmet öne çıkarıldı!') : __('Hizmet öne çıkarılmaktan kaldırıldı!')
        ]);
    }
}







