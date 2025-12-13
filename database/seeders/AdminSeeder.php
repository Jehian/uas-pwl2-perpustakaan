<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@library.com',
            'password' => Hash::make('password123'), // Password admin
            'role' => 'admin'
        ]);
    }
}
