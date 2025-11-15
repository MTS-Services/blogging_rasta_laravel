<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $masterView = 'frontend.pages.blog';

    public function blog()
    {
        return view($this->masterView);
    }
}
