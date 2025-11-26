<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Services\AboutCmsService;

class AboutCmsController extends Controller
{
    protected $masterView = 'backend.admin.pages.about-cms';

    public function __construct(protected AboutCmsService $service)
    {
    }

    /**
     * banner page index
     */
    public function index()
    {
        return view($this->masterView);
    }
}
