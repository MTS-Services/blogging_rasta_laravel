<?php

namespace App\Actions\Admin;


use App\Events\Admin\AdminCreated;
use App\Models\Admin;
use App\Repositories\Contracts\AdminRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    public function __construct(public AdminRepositoryInterface $interface) {}

    public function execute(array $data): Admin
    {
        return DB::transaction(function () use ($data) {

            // Handle avatar upload
            // if ($data['avatar']) {
            //     $data['avatar'] = Storage::disk('public')->putFile('admins', $data['avatar']);
            // }
               if ($data['avatar']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['avatar']->getClientOriginalName();
                $data['avatar'] = Storage::disk('public')->putFileAs('admins',  $data['avatar'], $fileName);
            }

            // Create user
            $model = $this->interface->create($data);

            // Dispatch event
            event(new AdminCreated($model));

            return $model->fresh();
        });
    }
}
