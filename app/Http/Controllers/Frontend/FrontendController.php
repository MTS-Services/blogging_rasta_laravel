<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected $masterView = 'frontend.pages.frontend';

    public function home()
    {
        return view($this->masterView);
    }
    public function products()
    {
        return view($this->masterView);
    }
}
