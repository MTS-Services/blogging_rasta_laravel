<?php

namespace App\Http\Controllers\Backend\Admin\GameManagement;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Services\GameService;

class GameController extends Controller
{
    //
    protected GameService $service;

    public Game $data ;
    public function __construct(GameService $service)
    {
        $this->service = $service;
    }
    public $masterView = 'backend.admin.pages.game-management.game';
    public function index()
    {
        return view($this->masterView);
    }

    public function create()
    {
        return view($this->masterView);
    }

    public function show($id)
    {
        $this->data = $this->service->findData($id);

        return view($this->masterView, [
            'data' => $this->data,
        ]);
    }
    public function edit($id)    
    {
        $this->data = $this->service->findData($id);
        return view($this->masterView, [
            'data' => $this->data,
        ]); 
    }
    public function trash()
    {
        return view($this->masterView);
    }


}
