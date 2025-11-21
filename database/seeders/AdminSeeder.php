<?php

namespace Database\Seeders;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@dev.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('superadmin@dev.com'),
        ]);
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('admin@dev.com'),
        ]);

    }
}
