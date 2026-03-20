<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Sitemap XML for companies (for search engines).
     *
     * @return \Illuminate\Http\Response
     */
    public function companies()
    {
        $companies = Company::active()
            ->whereNotNull('slug')
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'slug', 'updated_at']);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $baseUrl = rtrim(config('app.url'), '/');

        foreach ($companies as $company) {
            $url = $baseUrl . '/company/' . $company->slug;
            $lastmod = $company->updated_at ? $company->updated_at->format('Y-m-d') : date('Y-m-d');
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . $lastmod . '</lastmod>' . "\n";
            $xml .= '    <changefreq>weekly</changefreq>' . "\n";
            $xml .= '    <priority>0.8</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Charset' => 'UTF-8',
        ]);
    }
}
