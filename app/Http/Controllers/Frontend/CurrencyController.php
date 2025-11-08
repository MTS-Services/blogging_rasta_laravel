<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
     protected $masterView = 'frontend.pages.currency';

    public function index()
    {
        return view($this->masterView);
    }
}
