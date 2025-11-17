<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $masterView = 'frontend.pages.blog';

    public function __construct(protected BlogService $service) {}

    public function blog()
    {
        return view($this->masterView);
    }

    public function details(string $slug)
    {
        $data = $this->service->findSlugData($slug);
        // dd($data);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }
}
