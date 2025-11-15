<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    protected $masterView = 'frontend.pages.static';
    public function PrivacyPolicy()
    {
        return view($this->masterView);
    }
    public function TermsOfService()
    {
        return view($this->masterView);
    }

    public function affiliate()
    {
        return view($this->masterView);
    }
}
