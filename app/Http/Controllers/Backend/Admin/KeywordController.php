<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Services\KeywordService;
use App\Http\Controllers\Controller;

class KeywordController extends Controller
{
    protected $masterView = 'backend.admin.pages.keyword';
    public function __construct(protected KeywordService $service) {}

    /**
     * Show the list of resources.
     */
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function view(string $encryptedId)
    {
        $data = $this->service->findData(decrypt($encryptedId));
        // dd($data);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    /**
     * Display the trashed resource.
     */
    public function trash()
    {
        return view($this->masterView);
    }
}
