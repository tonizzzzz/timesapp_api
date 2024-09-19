<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now(); // Obtener la fecha y hora actual

        DB::table('users')->insert([
            // Users for the Software department
            ['name' => 'user1', 'email' => 'user1@company.com', 'password' => Hash::make('user1'), 'role' => 'manager', 'created_at' => $now, 'updated_at' => $now], // Manager
            ['name' => 'user2', 'email' => 'user2@company.com', 'password' => Hash::make('user2'), 'role' => 'employee', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'user3', 'email' => 'user3@company.com', 'password' => Hash::make('user3'), 'role' => 'employee', 'created_at' => $now, 'updated_at' => $now],

            // Users for the Sistemas department
            ['name' => 'user4', 'email' => 'user4@company.com', 'password' => Hash::make('user4'), 'role' => 'manager', 'created_at' => $now, 'updated_at' => $now], // Manager
            ['name' => 'user5', 'email' => 'user5@company.com', 'password' => Hash::make('user5'), 'role' => 'employee', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'user6', 'email' => 'user6@company.com', 'password' => Hash::make('user6'), 'role' => 'employee', 'created_at' => $now, 'updated_at' => $now],

            // Users for the Business Intelligence department
            ['name' => 'user7', 'email' => 'user7@company.com', 'password' => Hash::make('user7'), 'role' => 'manager', 'created_at' => $now, 'updated_at' => $now], // Manager
            ['name' => 'user8', 'email' => 'user8@company.com', 'password' => Hash::make('user8'), 'role' => 'employee', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'user9', 'email' => 'user9@company.com', 'password' => Hash::make('user9'), 'role' => 'employee', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'user10', 'email' => 'user10@company.com', 'password' => Hash::make('user10'), 'role' => 'employee', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
