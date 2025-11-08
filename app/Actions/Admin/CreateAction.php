<?php

namespace App\Actions\Admin;


use App\Events\Admin\AdminCreated;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(
        protected AdminRepositoryInterface $interface
    ) {}


    public function execute(array $data): Admin
    {
        return DB::transaction(function () use ($data) {
          
            // Handle avatar upload
            if ($data['avatar']) {
                $data['avatar'] = Storage::disk('public')->putFile('admins', $data['avatar']);
            }
            

            // Create user
            $admin = $this->interface->create($data);

            // Dispatch event
            event(new AdminCreated($admin));

            return $admin->fresh();
        });
    }
}
