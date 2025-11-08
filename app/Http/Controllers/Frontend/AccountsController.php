<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    protected $masterView = 'frontend.pages.accounts';

    public function index()
    {
        return view($this->masterView);
    }
}
