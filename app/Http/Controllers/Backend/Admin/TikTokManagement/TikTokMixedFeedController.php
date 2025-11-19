<?php

namespace App\Http\Controllers\Backend\Admin\TikTokManagement;

use App\Http\Controllers\Controller;
use App\Models\TikTokVideo;
use Illuminate\Http\Request;

class TikTokMixedFeedController extends Controller
{
      protected $masterView = 'backend.admin.pages.tiktok-management.tiktok-mixed-feed';

    public function index()
    {
        return view($this->masterView);
    }
    public function videoKeyword(string $encryptedId)
    {
        $data = TikTokVideo::findOrFail(decrypt($encryptedId));
        if (!$data) {
            abort(404);
        }
        return view($this->masterView, [
            'data' => $data
        ]);
    }

}
