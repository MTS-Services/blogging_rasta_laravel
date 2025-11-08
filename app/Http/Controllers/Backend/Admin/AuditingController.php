<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;

class AuditingController extends Controller
{
    protected $masterView = 'backend.admin.pages.auditing';

    public function index()
    {
        return view($this->masterView);
    }
    /**
     * Display the specified resource.
     */
    public function view(string $id)
    {
        $data = Audit::find($id);
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }
}
