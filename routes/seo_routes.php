<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Seo;

/*
|--------------------------------------------------------------------------
| SEO & Dynamic Routes
|--------------------------------------------------------------------------
|
| This file registers routes dynamically based on the 'seo' table in the database.
| It allows for custom slugs for pages like Jobs, Companies, Contact, etc.
|
*/

if (Schema::hasTable('seo')) {
    try {
        // Fetch all pages that have a custom slug defined
        $pages = Seo::whereNotNull('slug')
            ->whereNotNull('controller_action')
            ->where('slug', '!=', '')
            ->get();

        foreach ($pages as $page) {
            // Register the route
            // We use 'any' to cover both GET and potentially POST if needed, 
            // but for SEO pages GET is usually sufficient. 
            // However, contact forms might post to the same URL, so we should be careful.
            // For now, we'll stick to GET as these are primary display pages.
            // If the controller expects POST, it usually has a separate route definition.

            // Avoid overriding the root route '/' if it's handled elsewhere, strictly speaking.
            // But if we want to dynamicize home, we can.

            if ($page->slug === '/') {
                Route::get('/', $page->controller_action)->name($page->route_name);
            } else {
                Route::get($page->slug, $page->controller_action)->name($page->route_name);
            }
        }
    } catch (\Exception $e) {
        // Failsafe: If DB connection fails or table missing, do nothing.
        // This prevents the application from crashing during migrations or setup.
        \Log::error('SEO Routes Error: ' . $e->getMessage());
    }
}
