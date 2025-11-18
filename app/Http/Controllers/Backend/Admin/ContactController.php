<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContactService;

class ContactController extends Controller
{
      protected $masterView = 'backend.admin.pages.contact';
    public function __construct(protected ContactService $service) {}

    /**
     * Show the list of resources.
     */
    public function index()
    {
        return view($this->masterView);
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
