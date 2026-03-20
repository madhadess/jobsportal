<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Input;
use Carbon\Carbon;
use Redirect;
use App\Seo;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\SeoFormRequest;
use App\Http\Controllers\Controller;

class SeoController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function indexSeo()
    {
        return view('admin.seo.index');
    }

    public function createSeo()
    {
        $seo = new Seo();
        $systemPages = [
            'front_index_page' => 'Ana Sayfa',
            'jobs' => 'İş İlanları',
            'companies' => 'Şirketler Listesi',
            'contact' => 'İletişim Sayfası',
            'blogs' => 'Blog Sayfası',
            'cms' => 'CMS Sayfası (Slug ile eşleşir)',
        ];
        return view('admin.seo.create')->with('seo', $seo)->with('systemPages', $systemPages);
    }

    public function storeSeo(SeoFormRequest $request)
    {
        $seo = new Seo();
        $seo->page_title = $request->input('page_title');
        $seo->seo_title = $request->input('seo_title');
        $seo->seo_description = $request->input('seo_description');
        $seo->seo_keywords = $request->input('seo_keywords');
        $seo->seo_other = $request->input('seo_other');
        $seo->slug = $request->input('slug');
        $seo->save();
        flash(__('SEO added successfully!'))->success();
        return \Redirect::route('list.seo');
    }

    public function editSeo($id)
    {
        $seo = Seo::findOrFail($id);
        return view('admin.seo.edit')->with('seo', $seo);
    }

    public function updateSeo($id, SeoFormRequest $request)
    {
        $seo = Seo::findOrFail($id);
        if ($request->has('page_title')) {
            $seo->page_title = $request->input('page_title');
        }
        $seo->seo_title = $request->input('seo_title');
        $seo->seo_description = $request->input('seo_description');
        $seo->seo_keywords = $request->input('seo_keywords');
        $seo->seo_other = $request->input('seo_other');
        $seo->slug = $request->input('slug');
        $seo->update();
        flash(__('SEO updated successfully!'))->success();
        return \Redirect::route('edit.seo', array($seo->id));
    }

    public function fetchSeoData(Request $request)
    {
        $seo = Seo::select(
            [
                'seo.id',
                'seo.page_title',
                'seo.slug',
                'seo.seo_title',
                'seo.seo_description',
                'seo.seo_keywords',
                'seo.seo_other',
                'seo.created_at',
                'seo.updated_at'
            ]
        );
        return Datatables::of($seo)
            ->filter(function ($query) use ($request) {
                if ($request->has('id') && !empty($request->id)) {
                    $query->where('seo.id', 'like', "{$request->get('id')}");
                }
                if ($request->has('page_title') && !empty($request->page_title)) {
                    $query->where('seo.page_title', 'like', "%{$request->get('page_title')}%");
                }
                if ($request->has('slug') && !empty($request->slug)) {
                    $query->where('seo.slug', 'like', "%{$request->get('slug')}%");
                }
            })
            ->editColumn('page_title', function ($seo) {
                $systemPages = [
                    'front_index_page' => 'Ana Sayfa',
                    'jobs' => 'İş İlanları',
                    'companies' => 'Şirketler Listesi',
                    'contact' => 'İletişim Sayfası',
                    'blogs' => 'Blog Sayfası',
                    'cms' => 'CMS Sayfası',
                ];
                return $systemPages[$seo->page_title] ?? $seo->page_title;
            })
            ->addColumn('action', function ($seo) {
                /*                             * ************************* */
                return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">' . __('Action') . '
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.seo', ['id' => $seo->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>' . __('Edit') . '</a>
						</li>																																													
					</ul>
				</div>';
            })
            ->rawColumns(['action'])
            ->setRowId(function ($seo) {
                return 'seo_dt_row_' . $seo->id;
            })
            ->make(true);
    }

}







