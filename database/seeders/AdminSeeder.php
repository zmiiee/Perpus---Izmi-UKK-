<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Perpustakaan 1',
            'email' => 'admin1@perpus.com',
            'password' => Hash::make('admin123'),
            'role' => 'Admin'
        ]);

        User::create([
            'name' => 'Admin Perpustakaan 2',
            'email' => 'admin2@perpus.com',
            'password' => Hash::make('admin123'),
            'role' => 'Admin'
        ]);
    }
}
