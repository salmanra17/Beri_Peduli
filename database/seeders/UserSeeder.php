<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@beripeduli.com',
            ],
            [
                'name' => 'Admin BeriPeduli',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
                'no_hp' => '08123456789',
                'alamat' => 'Jakarta',
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'user@beripeduli.com',
            ],
            [
                'name' => 'User Donatur',
                'password' => Hash::make('user12345'),
                'role' => 'donatur',
                'no_hp' => '081234567890',
                'alamat' => 'Jakarta',
            ]
        );
    }
}
