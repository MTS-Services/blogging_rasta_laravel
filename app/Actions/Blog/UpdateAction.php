<?php

namespace App\Actions\Blog;


use App\Events\Admin\AdminUpdated;
use App\Models\Blog;
use App\Repositories\Contracts\BlogRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateAction
{
    public function __construct(public BlogRepositoryInterface $interface) {}

    public function execute(int $id,  array $data): Blog
    {
        return DB::transaction(function () use ($id, $data) {

            $model = $this->interface->find($id);

            if (!$model) {
                Log::error('Data not found', ['blog_id' => $id]);
                throw new \Exception('Blog not found');
            }

            if ($data['avatar']) {
                // Handle Avatar upload Logic will be here....
            }

            $data['password'] = $data['password'] ?? $model->password;

            // Update Admin
            $updated = $this->interface->update($id, $data);

            if (!$updated) {
                Log::error('Failed to update Data in repository', ['blog_id' => $id]);
                throw new \Exception('Failed to update Blog');
            }

            // Refresh the Blog model
            $model = $model->fresh();

            return $model;
        });
    }
}
