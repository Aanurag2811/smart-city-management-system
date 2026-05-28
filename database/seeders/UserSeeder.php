<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'System Admin',
            'email' => 'admin@smartcity.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Transport Manager',
            'email' => 'transport@smartcity.com',
            'password' => bcrypt('password'),
            'role' => 'transport_manager',
        ]);

        \App\Models\User::create([
            'name' => 'Logistics Manager',
            'email' => 'logistics@smartcity.com',
            'password' => bcrypt('password'),
            'role' => 'logistics_manager',
        ]);

        \App\Models\User::create([
            'name' => 'John Citizen',
            'email' => 'citizen@smartcity.com',
            'password' => bcrypt('password'),
            'role' => 'citizen',
        ]);
    }
}
