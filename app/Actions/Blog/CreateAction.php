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

            // Handle avatar upload
            if ($data['file']) {
                $data['file'] = Storage::disk('public')->putFile('blogs', $data['file']);
            }


            // Create user
            $model = $this->interface->create($data);


            return $model->fresh();
        });
    }
}
