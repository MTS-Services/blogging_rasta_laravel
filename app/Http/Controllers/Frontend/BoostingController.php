<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BoostingController extends Controller
{
    protected $masterView = 'frontend.pages.boosting';

    public function index()
    {
        return view($this->masterView);
    }
    public function sellerList()
    {
        return view($this->masterView);
    }
    public function buyNow()
    {
        return view($this->masterView);
    }
    public function checkout()
    {
        return view($this->masterView);
    }
}
