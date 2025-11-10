<?php

namespace App\Actions\User;


// use App\Events\Admin\AdminCreated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(public UserRepositoryInterface $interface) {}

    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {

            // Handle avatar upload
            if ($data['avatar']) {
                $data['avatar'] = Storage::disk('public')->putFile('users', $data['avatar']);
            }

            // Create user
            $model = $this->interface->create(data: $data);

            // Dispatch event
            // event(new AdminCreated($model));

            return $model->fresh();
        });
    }
}
