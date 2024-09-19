<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\UpdateUserDepartmentSeeder;
use Database\Seeders\UpdateDepartmentManagerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DepartmentSeeder::class,
            UpdateUserDepartmentSeeder::class,
            UpdateDepartmentManagerSeeder::class
        ]);
    }
}
