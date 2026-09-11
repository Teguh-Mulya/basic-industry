<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@basicindustry.test',
            'password' => Hash::make('Admin12345'),
            'role' => 'admin',
        ]);

        // Pemilik
        User::create([
            'name' => 'Pemilik Basic Industry',
            'email' => 'pemilik@basicindustry.test',
            'password' => Hash::make('Pemilik12345'),
            'role' => 'pemilik',
        ]);

        // Admin Penjualan
        User::create([
            'name' => 'Admin Penjualan',
            'email' => 'penjualan@basicindustry.test',
            'password' => Hash::make('Penjualan12345'),
            'role' => 'admin_penjualan',
        ]);

        // Customer
        User::create([
            'name' => 'Customer Basic Industry',
            'email' => 'customer@basicindustry.test',
            'password' => Hash::make('Customer12345'),
            'role' => 'customer',
        ]);
    }
}