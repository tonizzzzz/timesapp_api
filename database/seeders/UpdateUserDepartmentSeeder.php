<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar el departamento a los usuarios
        DB::table('users')->where('email', 'user1@company.com')->update(['department_id' => 1]);
        DB::table('users')->where('email', 'user2@company.com')->update(['department_id' => 1]);
        DB::table('users')->where('email', 'user3@company.com')->update(['department_id' => 1]);

        DB::table('users')->where('email', 'user4@company.com')->update(['department_id' => 2]);
        DB::table('users')->where('email', 'user5@company.com')->update(['department_id' => 2]);
        DB::table('users')->where('email', 'user6@company.com')->update(['department_id' => 2]);

        DB::table('users')->where('email', 'user7@company.com')->update(['department_id' => 3]);
        DB::table('users')->where('email', 'user8@company.com')->update(['department_id' => 3]);
        DB::table('users')->where('email', 'user9@company.com')->update(['department_id' => 3]);
        DB::table('users')->where('email', 'user10@company.com')->update(['department_id' => 3]);
    }
}
