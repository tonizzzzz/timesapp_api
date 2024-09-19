<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {

        // Crear departamentos válidos antes del test
        Department::factory()->create(['id' => 1]);
        Department::factory()->create(['id' => 2]);

        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'department_id' => 1,  // Asegúrate de tener este departamento en la base de datos
        ]);

        $response->assertStatus(201);

        // Verificar que se creó el usuario en la base de datos
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        // Verificar que se devolvió un token de autenticación
        $response->assertJsonStructure(['token']);
    }

    /** @test */
    public function user_cannot_register_with_existing_email()
    {
        // Crear un usuario existente
        User::factory()->create(['email' => 'test@example.com']);

        // Intentar registrar otro usuario con el mismo correo electrónico
        $response = $this->postJson('/api/register', [
            'name' => 'Another User',
            'email' => 'test@example.com',
            'password' => 'password',
            'department_id' => 1,
        ]);

        // Debe fallar la validación
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function user_can_login()
    {
        // Crear un usuario
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Intentar iniciar sesión con credenciales correctas
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        // Verificar que se devolvió un token de autenticación
        $response->assertJsonStructure(['token']);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        // Crear un usuario
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Intentar iniciar sesión con una contraseña incorrecta
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        // Debe fallar la autenticación
        $response->assertStatus(422);
    }
}
