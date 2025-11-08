<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    protected $masterView = 'frontend.pages.userProfile';

    public function profile()
    {
        return view($this->masterView);
    }
}
