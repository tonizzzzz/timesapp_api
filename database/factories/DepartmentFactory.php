<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,  // Genera un nombre de departamento aleatorio
            'manager_id' => null,          // Deja el manager como null si es opcional
        ];
    }
}
