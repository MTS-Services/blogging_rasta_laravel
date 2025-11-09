<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserType;
use App\Enums\UserStatus;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Enums\userKycStatus;
use Illuminate\Database\Seeder;
use App\Enums\UserAccountStatus;
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
            'name' => 'User',
            'email' => 'user@dev.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('user@dev.com'),
            'status' => UserStatus::ACTIVE->value,
            'created_at' => Carbon::now(),
        ]);
        User::create([
            'name' => 'User 2',
            'email' => 'user2@dev.com',
            'password' => Hash::make('user2@dev.com'),
            'status' => UserStatus::ACTIVE->value,
            'created_at' => Carbon::now(),
        ]);

        User::factory(100)->create();
    }
}
