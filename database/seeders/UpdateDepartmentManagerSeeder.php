<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateDepartmentManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar manager a los departamentos
        DB::table('departments')->where('name', 'Software')->update(['manager_id' => 11]); // user1
        DB::table('departments')->where('name', 'Sistemas')->update(['manager_id' => 4]); // user4
        DB::table('departments')->where('name', 'Business Intelligence')->update(['manager_id' => 7]); // user7
    }
}
