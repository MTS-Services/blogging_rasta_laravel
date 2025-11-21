<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserStatus;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'user',
            'name' => 'User',
            'date_of_birth' => Carbon::now(),
            'email' => 'user@dev.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('user@dev.com'),
            'status' => UserStatus::ACTIVE->value,
            'created_at' => Carbon::now(),
        ]);
        User::create([
            'username' => 'user2',
            'name' => 'User 2',
            'date_of_birth' => Carbon::now(),
            'email' => 'user2@dev.com',
            'password' => Hash::make('user2@dev.com'),
            'status' => UserStatus::ACTIVE->value,
            'created_at' => Carbon::now(),
        ]);

    }
}
