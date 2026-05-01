<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Admin Nizam',
            'email' => 'aryamuzaqqinew1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Owner
        User::create([
            'name' => 'Owner Nizam',
            'email' => '220101082@mhs.udb.ac.id',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);
    }
}