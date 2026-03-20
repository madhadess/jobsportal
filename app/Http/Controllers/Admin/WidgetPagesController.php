<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WidgetPages;
use Illuminate\Support\Str;

class WidgetPagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /* public function __construct()
     {
         $this->middleware('admin.auth:admin');
     }*/

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array();
        $data['widget_pages'] = WidgetPages::get();
        return view('admin.widget_pages.index')->with($data);
    }

    public function add()
    {
        return view('admin.widget_pages.add');
    }

    public function edit($id)
    {
        $data = array();
        $data['widget_page'] = WidgetPages::findorFail($id);
        return view('admin.widget_pages.edit')->with($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ], [
            'title.required' => __('Widget Sayfa Başlığı zorunludur.'),
        ]);
        $slug = Str::slug($request->title, '-');
        $slugs = unique_slug($slug, 'widget_pages', $field = 'slug', $key = NULL, $value = NULL);
        $menu_type = new WidgetPages();
        $menu_type->title = $request->title;
        $menu_type->slug = $slugs;
        $menu_type->save();
        if ($menu_type->save() == true) {
            flash(__('Widget Sayfası başarıyla oluşturuldu!'))->success();
        }
        return redirect(route('admin.widget_pages'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ], [
            'title.required' => __('Menü Başlığı zorunludur.'),
        ]);
        $menu_type = WidgetPages::findorFail($request->id);

        if (trim($menu_type->title) != trim($request->title)) {
            $slug = Str::slug($request->title, '-');
            $slugs = unique_slug($slug, 'widget_pages', $field = 'slug', $key = NULL, $value = NULL);
            $menu_type->slug = $slugs;
        }

        $menu_type->title = $request->title;

        $menu_type->update();
        if ($menu_type->update() == true) {
            flash(__('Widget Sayfası başarıyla güncellendi!'))->success();
        }
        return redirect(route('admin.widget_pages'));
    }

    public function destroy(Request $request, $id)
    {
        $menu_type = WidgetPages::findOrFail($id);
        $menu_type->delete();
        flash(__('Widget Sayfası başarıyla silindi!'))->success();
        return redirect(route('admin.widget_pages'));
    }
}




