<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now(); // Obtener la fecha y hora actual

        DB::table('departments')->insert([
            ['name' => 'Software', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sistemas', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Business Intelligence', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
