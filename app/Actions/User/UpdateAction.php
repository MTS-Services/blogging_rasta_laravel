<?php

namespace App\Actions\User;

use App\Events\User\UserUpdated;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateAction
{
    public function __construct(
        protected UserRepositoryInterface $interface
    ) {}

    public function execute(int $userId, array $data): User
    {
        return DB::transaction(function () use ($userId, $data) {
            $user = $this->interface->find($userId);

            if (!$user) {
                Log::error('User not found', ['user_id' => $userId]);
                throw new \Exception('User not found');
            }

            // Store old data BEFORE any modifications
            $oldData = $user->getAttributes();
            
            Log::info('User found', [
                'user_id' => $userId,
                'user_data' => $oldData
            ]);
            

            $new_data = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'country_id' => $data['country_id'],
                'date_of_birth' => $data['date_of_birth'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'account_status' => $data['account_status'],                
                'updater_id' => admin()->id,
            ];

            if($data['password'] != null && $data['password'] != '' && $data['password']){

                $new_data['password'] = $data['password'];

            }
          
             if($data['avatar']) {

                $new_data['avatar'] = Storage::disk('public')->putFile('admins', $data['avatar']);

                if (Storage::disk('public')->exists($oldData['avatar'])) {

                    Storage::disk('public')->delete($oldData['avatar']);
                }   
            }

       

            // Update user
            $updated = $this->interface->update($userId, $new_data);
            
            if (!$updated) {
                Log::error('Failed to update user in repository', ['user_id' => $userId]);
                throw new \Exception('Failed to update user');
            }

            // Refresh the user model
            $user = $user->fresh();

            // Dispatch event
            event(new UserUpdated($user, $oldData));
            return $user;
        });
    }
}