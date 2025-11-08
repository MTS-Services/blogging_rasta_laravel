<?php

namespace App\Actions\User;

use App\Events\User\UserCreated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(
        protected UserRepositoryInterface $interface
    ) {}

    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {

                if ($data['avatar']) {
                     $data['avatar'] = Storage::disk('public')->putFile('admins', $data['avatar']);
                }


            // Create user
           
            $user = $this->interface->create($data);

            // Dispatch event
            event(new UserCreated($user));

            return $user->fresh();
        });
    }
}