<?php

namespace App\Http\Controllers\Backend\Admin\ReviewManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\PageViewService;

class PageViewController extends Controller
{
    protected $masterView = 'backend.admin.pages.review-management.pageView';
    public function __construct(protected PageViewService $service) {}

    public function index()
    {
        return view($this->masterView);
    }
    public function show(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }
    public function trash()
    {
        return view($this->masterView);
    }
}
