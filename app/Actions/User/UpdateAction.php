<?php

namespace App\Actions\User;


// use App\Events\Admin\AdminUpdated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateAction
{
    public function __construct(public UserRepositoryInterface $interface) {}

    public function execute(int $id,  array $data): User
    {
        return DB::transaction(function () use ($id, $data) {

            $model = $this->interface->find(column_value: $id);

            if (!$model) {
                Log::error('User not found', ['user_id' => $id]);
                throw new \Exception('User not found');
            }

            if ($data['avatar']) {
                // Handle Avatar upload Logic will be here....
            }

            $data['password'] = $data['password'] ?? $model->password;

            // Update Model
            $updated = $this->interface->update(id: $id, data: $data);

            if (!$updated) {
                Log::error('Failed to update User in repository', ['user_id' => $id]);
                throw new \Exception('Failed to update User');
            }

            // Refresh the model
            $model = $model->fresh();

            // event(new AdminUpdated($model, $data));

            return $model;
        });
    }
}
