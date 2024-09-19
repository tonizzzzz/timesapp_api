<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TimeEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Tests\TestCase;

class TimeEntryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::now());  // Fijar el tiempo actual para las pruebas
    }

    /** @test */
    public function user_can_clock_in()
    {
        // Crear un usuario
        $user = User::factory()->create();

        // Simular autenticación del usuario
        $this->actingAs($user);

        // Hacer la petición de clock-in
        $response = $this->postJson('/api/clock-in');

        // Verificar que la respuesta sea 201 (creado)
        $response->assertStatus(201);

        // Verificar que se haya creado una entrada en la base de datos
        $this->assertDatabaseHas('time_entries', [
            'user_id' => $user->id,
            'clock_out' => null,  // clock_out debe estar nulo porque es Clock In
        ]);
    }

    /** @test */
    public function user_can_clock_out()
    {
        // Crear un usuario antes de la entrada de tiempo
        $user = User::factory()->create();

        // Crear una entrada de tiempo asociada al usuario
        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,  // Asociar la entrada con el usuario
            'clock_in' => now()->subHours(1),
        ]);

        // Autenticar al usuario
        $this->actingAs($user, 'sanctum');

        // Hacer la petición de Clock Out
        $response = $this->postJson('/api/clock-out/' . $timeEntry->id);

        // Verificar el estado HTTP
        $response->assertStatus(200);  // Espera un 200 OK
    }

    /** @test */
    public function user_can_check_clock_in_today()
    {
        // Crear un usuario antes de la entrada de tiempo
        $user = User::factory()->create();

        // Crear una entrada de tiempo asociada al usuario
        $timeEntry = TimeEntry::factory()->create([
            'user_id' => $user->id,  // Asociar la entrada con el usuario
            'clock_in' => now()->subHours(1),
            'clock_out' => null,  // Aún no ha hecho clock-out
        ]);

        // Hacer login como el usuario
        $this->actingAs($user);

        // Enviar la petición para revisar el clock-in de hoy
        $response = $this->getJson('/api/clock-in-today');

        $response->assertStatus(200)
        ->assertJson([
            'clock_in_time' => $timeEntry->clock_in->format('Y-m-d H:i:s'),  // Formato de fecha de Laravel
            'accumulated_time' => 3600,  // 1 hora en segundos
            'is_clocked_in' => true,
            'entry_id' => $timeEntry->id,
        ]);
    
    }
}
