<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use App\Seo;

class SeoComposer
{
    public function compose(View $view)
    {
        // If SEO data is already provided (e.g. by Controller), do not override it.
        if ($view->offsetExists('seo')) {
            return;
        }

        $routeName = Route::currentRouteName();

        if ($routeName) {
            $seo = Seo::where('route_name', $routeName)->first();

            if ($seo) {
                $view->with('seo', $seo);
            }
        }
    }
}
