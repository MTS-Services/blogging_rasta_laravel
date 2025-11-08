<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;

use App\Services\GameCategoryService;
use Illuminate\View\View;

class CategoryController extends Controller
{

    
    protected $masterView = 'backend.admin.pages.game-management.game-category';
    protected GameCategoryService $service;
    public function __construct(GameCategoryService $service)
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

    public function edit($id):View
    {

        $data = $this->service->findData(decrypt($id));
        return view($this->masterView , [
            'data'  => $data
        ]);
    }
    public function show($id)
    {
        
      
        $data = $this->service->findData(decrypt($id));
        if (!$data) {
            abort(404);
        }

        return view($this->masterView , [
            'data'  => $data
        ]);
    }

    public function trash(){

        return view($this->masterView);

    }

}
