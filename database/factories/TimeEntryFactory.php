<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\TimeEntry;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeEntryFactory extends Factory
{
    protected $model = TimeEntry::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Relación con el modelo User
            'clock_in' => now()->subHours(2), // Hora de entrada hace 2 horas
            'clock_out' => now(), // Hora de salida actual (puede ser nullable si no se ha hecho clock-out)
        ];
    }
}
