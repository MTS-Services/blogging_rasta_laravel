<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\SitemapService;

class SitemapController extends Controller
{
    protected SitemapService $sitemapService;

    public function __construct(SitemapService $sitemapService)
    {
        $this->sitemapService = $sitemapService;
    }
    public function generate()
    {
        $this->sitemapService->generate();
        return response()->download(public_path('sitemap.xml'));
    }
}
