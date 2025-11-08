<?php

namespace App\Http\Controllers\Backend\Admin\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected $masterView = 'backend.admin.pages.language.language';

    public function index()
    {
        return view($this->masterView);
    }
    public function create()
    {
        return view($this->masterView);
    }

}
