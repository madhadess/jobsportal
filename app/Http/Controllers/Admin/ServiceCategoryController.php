<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ServiceCategory;
use App\ServiceOption;
use Illuminate\Support\Str;

class ServiceCategoryController extends Base
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'service');
        $categories = ServiceCategory::where('type', $type)->orderBy('sort_order', 'asc')->get();
        return view('admin.service_categories.index', compact('categories', 'type'));
    }

    public function create(Request $request)
    {
        $type = $request->input('type', 'service');
        return view('admin.service_categories.create', compact('type'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required|max:255',
            'category_desc' => 'nullable',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'sort_order' => 'nullable|integer'
        ], [
            'category_name.required' => __('Kategori adı zorunludur.'),
            'category_image.image' => __('Sadece görsel dosyaları yüklenebilir.'),
            'category_image.mimes' => __('Görsel formatı jpeg, png, jpg veya gif olmalıdır.'),
            'category_image.max' => __('Görsel boyutu maksimum 2MB olabilir.'),
        ]);

        $category = new ServiceCategory();
        $category->category_name = $request->category_name;
        $category->type = $request->input('type', 'service');
        $category->category_slug = Str::slug($request->category_name, '-');
        $category->category_desc = $request->category_desc;
        $category->is_active = $request->is_active;
        $category->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $imageName = time() . '_' . Str::slug($request->category_name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/service_categories'), $imageName);
            $category->category_image = $imageName;
        }

        $category->save();

        flash(__('Hizmet kategorisi başarıyla eklendi!'))->success();

        return redirect()->route('admin.service-categories.index', ['type' => $category->type]);
    }

    public function edit($id)
    {
        $category = ServiceCategory::findOrFail($id);
        $type = $category->type;
        $options = ServiceOption::where('category_id', $id)->orderBy('sort_order', 'asc')->get();
        return view('admin.service_categories.edit', compact('category', 'type', 'options'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_name' => 'required|max:255',
            'category_desc' => 'nullable',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|boolean',
            'sort_order' => 'nullable|integer'
        ], [
            'category_name.required' => __('Kategori adı zorunludur.'),
            'category_image.image' => __('Sadece görsel dosyaları yüklenebilir.'),
            'category_image.mimes' => __('Görsel formatı jpeg, png, jpg veya gif olmalıdır.'),
            'category_image.max' => __('Görsel boyutu maksimum 2MB olabilir.'),
        ]);

        $category = ServiceCategory::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->category_slug = Str::slug($request->category_name, '-');
        $category->category_desc = $request->category_desc;
        $category->is_active = $request->is_active;
        $category->sort_order = $request->sort_order ?? 0;

        if ($request->hasFile('category_image')) {
            // Eski görseli sil
            if ($category->category_image && file_exists(public_path('uploads/service_categories/' . $category->category_image))) {
                unlink(public_path('uploads/service_categories/' . $category->category_image));
            }

            $image = $request->file('category_image');
            $imageName = time() . '_' . Str::slug($request->category_name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/service_categories'), $imageName);
            $category->category_image = $imageName;
        }

        $category->save();

        flash(__('Hizmet kategorisi başarıyla güncellendi!'))->success();

        return redirect()->route('admin.service-categories.index', ['type' => $category->type]);
    }

    public function destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);

        // Görseli sil
        if ($category->category_image && file_exists(public_path('uploads/service_categories/' . $category->category_image))) {
            unlink(public_path('uploads/service_categories/' . $category->category_image));
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => __('Hizmet kategorisi başarıyla silindi!')
        ]);
    }

    public function toggleStatus($id)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'success' => true,
            'is_active' => $category->is_active,
            'message' => $category->is_active ? __('Kategori aktif edildi!') : __('Kategori pasif edildi!')
        ]);
    }

    public function updateOptions(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);

        if ($request->has('options')) {
            foreach ($request->options as $optionData) {
                if (!empty($optionData['id'])) {
                    $option = ServiceOption::find($optionData['id']);
                } else {
                    if (empty($optionData['option_name']))
                        continue;
                    $option = new ServiceOption();
                    $option->category_id = $id;
                }

                if (empty($optionData['option_name'])) {
                    if (isset($option))
                        $option->delete();
                    continue;
                }

                $option->option_type = $optionData['option_type'] ?? 'attribute';
                $option->option_name = $optionData['option_name'];
                $option->is_active = $optionData['is_active'] ?? 1;
                $option->sort_order = $optionData['sort_order'] ?? 0;
                $option->save();
            }
        }

        flash(__('Kategori seçenekleri başarıyla güncellendi!'))->success();
        return redirect()->back();
    }

    public function deleteOption($id)
    {
        $option = ServiceOption::findOrFail($id);
        $option->delete();

        return response()->json([
            'success' => true,
            'message' => __('Seçenek başarıyla silindi!')
        ]);
    }
}







