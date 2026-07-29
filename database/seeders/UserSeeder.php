<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utero',
            'email' => 'admin@uterogroup.com',
            'password' => 'password',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Editor Utero',
            'email' => 'editor@uterogroup.com',
            'password' => 'password',
            'role' => 'editor',
            'email_verified_at' => now(),
        ]);
    }
}
