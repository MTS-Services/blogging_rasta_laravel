<?php

namespace App\Actions\User;

use App\Events\User\UserDeleted;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(
        protected UserRepositoryInterface $interface
    ) {}

    public function execute(int $userId, bool $forceDelete = false): bool
    {
        return DB::transaction(function () use ($userId, $forceDelete) {
            $user = $this->interface->find($userId);

            if (!$user) {
                throw new \Exception('User not found');
            }

            // Dispatch event before deletion
            event(new UserDeleted($user));

            if ($forceDelete) {
                // Delete avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                return $this->interface->forceDelete($userId);
            }

            return $this->interface->delete($userId);
        });
    }

    public function restore(int $userId, int $actionerId): bool
    {
        return $this->interface->restore($userId, $actionerId);
    }
}