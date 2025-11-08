<?php

namespace App\Http\Controllers\Backend\Admin\UserManagement;

use App\Http\Controllers\Controller;

use App\Services\UserService;


class UserController extends Controller
{
    protected $masterView = 'backend.admin.pages.user-management.user.user';

    protected UserService $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view($this->masterView);
    }
    public function create()
    {
        return view($this->masterView);
    }
    public function view(string $id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function edit(string $id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function trash()
    {
        return view($this->masterView);
    }
    public function profileInfo($id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function shopInfo($id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function kycInfo($id)
    {
        
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function statistic($id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
    public function referral($id)
    {
        $user = $this->service->getDataById($id);
        if (!$user) {
            abort(404);
        }
        return view($this->masterView, [
            'user' => $user
        ]);
    }
}
