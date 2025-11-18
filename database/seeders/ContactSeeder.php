<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'message' => 'This is a test message from a specific seeder entry.',
        ]);
        Contact::create([
            'name' => 'Jane Doe 2',
            'email' => 'jane.doe@example.com',
            'message' => 'This is a test message from a specific seeder entry.',
        ]);
        Contact::create([
            'name' => 'Jane Doe 3',
            'email' => 'jane.doe@example.com',
            'message' => 'This is a test message from a specific seeder entry.',
        ]);
        Contact::create([
            'name' => 'Jane Doe 4',
            'email' => 'jane.doe@example.com',
            'message' => 'This is a test message from a specific seeder entry.',
        ]);
        Contact::create([
            'name' => 'Jane Doe 5',
            'email' => 'jane.doe@example.com',
            'message' => 'This is a test message from a specific seeder entry.',
        ]);
        Contact::create([
            'name' => 'Jane Doe 6',
            'email' => 'jane.doe@example.com',
            'message' => 'This is a test message from a specific seeder entry.',
        ]);
        Contact::create([
            'name' => 'Jane Doe 7',
            'email' => 'jane.doe@example.com',
            'message' => 'This is a test message from a specific seeder entry.',
        ]);
    }
}
