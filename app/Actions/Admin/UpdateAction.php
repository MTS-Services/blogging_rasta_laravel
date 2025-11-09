<?php

namespace App\Actions\Admin;


use App\Events\Admin\AdminUpdated;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateAction
{
    public function __construct(
        protected AdminRepositoryInterface $interface
    ) {}

    public function execute(int $id,  array $data): Admin
    {
        return DB::transaction(function () use ($id, $data) {

            $admin = $this->interface->find($id);

            if (!$admin) {
                Log::error('Admin not found', ['admin_id' => $id]);
                throw new \Exception('Admin not found');
            }

            if ($data['avatar']) {
                // Handle Avatar upload Logic will be here....
            }

            $data['password'] = $data['password'] ?? $admin->password;

            // Update Admin
            $updated = $this->interface->update($id, $data);

            if (!$updated) {
                Log::error('Failed to update Admin in repository', ['admin_id' => $id]);
                throw new \Exception('Failed to update Admin');
            }

            // Refresh the Admin model
            $admin = $admin->fresh();

            event(new AdminUpdated($admin, $data));

            return $admin;
        });
    }
}
