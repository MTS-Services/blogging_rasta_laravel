<?php

namespace App\Http\Controllers\Backend\Admin\AdminManagement;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AdminService;

class AdminController extends Controller
{


    protected $masterView = 'backend.admin.pages.admin-management.admin.admin';

    public function __construct(protected AdminService $service){}

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
        $data = $this->service->findData($id);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    public function view(string $id)
    {
       $data = $this->service->findData($id);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

    public function trash()
    {
        return view($this->masterView);
    }
}
