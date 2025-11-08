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

            // dd($data);

            $admin = $this->interface->find($id);

            if (!$admin) {
                Log::error('Admin not found', ['admin_id' => $id]);
                throw new \Exception('Admin not found');
            }

            // Store old data BEFORE any modifications
            $oldData = $admin->getAttributes();

            $new_data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'status' => $data['status'],
                'updater_id' => $data['updater_id'],
            ];


            if($data['avatar']) {

                $new_data['avatar'] = Storage::disk('public')->putFile('admins', $data['avatar']);

                if (Storage::disk('public')->exists($oldData['avatar'])) {

                    Storage::disk('public')->delete($oldData['avatar']);
                }   
            }


                
            // // Handle avatar removal
            // if ($dto->removeAvatar && $admin->avatar) {
            //     Log::info('Removing avatar', ['path' => $admin->avatar]);
            //     Storage::disk('public')->delete($admin->avatar);
            //     $data['avatar'] = null;
            // }

            

            if($data['password'] && $data['password'] != '' && $data['password'] != null ) {
                $new_data['password'] = $data['password'];
            }


      
            Log::info('Data to update', ['data' => $data]);

            // Update Admin
            $updated = $this->interface->update($id, $new_data);

           

            if (!$updated) {
                Log::error('Failed to update Admin in repository', ['admin_id' => $id]);
                throw new \Exception('Failed to update Admin');
            }

            // Refresh the Admin model
            $admin = $admin->fresh();

            Log::info('Admin after update', [
                'admin_data' => $admin->getAttributes()
            ]);

            // Calculate changes - compare actual attributes, not toArray() which includes relations
            $newData = $admin->getAttributes();
            $changes = [];

            foreach ($newData as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            Log::info('Changes detected', ['changes' => $changes]);

            // Dispatch event only if there are actual changes
            if (!empty($changes)) {
                event(new AdminUpdated($admin, $changes));
            }

            return $admin;

            // 
        });
    }
}
