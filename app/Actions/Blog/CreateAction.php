<?php

namespace App\Actions\Blog;


use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(public BlogRepositoryInterface $interface) {}

    public function execute(array $data): Blog
    {
        return DB::transaction(function () use ($data) {
            $file = $data['file'] ?? null;
            if ($file instanceof \Illuminate\Http\UploadedFile) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $file->getClientOriginalName();
                $data['file'] = Storage::disk('public')->putFileAs('blogs', $file, $fileName);
            } else {
                $data['file'] = null;
            }

            // Create blog
            $model = $this->interface->create($data);

            return $model->fresh();
        });
    }
}
