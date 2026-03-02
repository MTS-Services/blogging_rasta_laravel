<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TinyMceUploadController extends Controller
{
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp,svg,bmp', 'max:15360'],
        ]);

        $file = $request->file('file');
        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '_' . time() . rand(1000, 9999)
            . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs('blog-content-images', $fileName, 'public');

        return response()->json([
            'location' => Storage::disk('public')->url($path),
        ]);
    }
}
