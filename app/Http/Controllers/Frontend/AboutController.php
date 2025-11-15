<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected $masterView = 'frontend.pages.about';

    public function about()
    {
        return view($this->masterView);
    }
}
