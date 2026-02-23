<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;

class BlogCommentController extends Controller
{
    protected string $masterView = 'backend.admin.pages.blog-comment';

    /**
     * List blog comments for moderation (pending / approved).
     */
    public function index(): \Illuminate\View\View
    {
        return view($this->masterView);
    }
}
