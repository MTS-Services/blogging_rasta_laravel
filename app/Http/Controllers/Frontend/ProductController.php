<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $masterView = 'frontend.pages.product';

    public function product()
    {
        return view($this->masterView);
    }
}
