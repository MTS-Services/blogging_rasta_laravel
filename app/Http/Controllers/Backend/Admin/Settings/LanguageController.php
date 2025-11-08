<?php

namespace App\Http\Controllers\Backend\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{


    protected $masterView = 'backend.admin.pages.settings.language';

    public function index()
    {
        return view($this->masterView);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->masterView);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $language = Language::find($id);
        if (!$language) {
            abort(404);
        }
        return view($this->masterView, [
            'language' => $language
        ]);
    }

    public function view(string $id)
    {
        $language = Language::find($id);
        if (!$language) {
            abort(404);
        }
        return view($this->masterView, [
            'language' => $language
        ]);
    }

    public function trash()
    {
        return view($this->masterView);
    }
}