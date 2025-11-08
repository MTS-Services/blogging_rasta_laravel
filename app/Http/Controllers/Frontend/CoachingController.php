<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoachingController extends Controller
{
    protected $masterView = 'frontend.pages.coaching';

    public function index()
    {
        return view($this->masterView);
    }
}
