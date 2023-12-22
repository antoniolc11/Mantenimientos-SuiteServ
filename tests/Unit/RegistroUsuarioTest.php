<?php

namespace Tests\Feature\Auth;

use App\Models\Departamento;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistroUsuarioTest extends TestCase
{
    //Metodo que comprueba que se puede acceder a la pantalla de inicio de sesión.
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    //Metodo que comprueba que se puede acceder a la pantalla de registro, logandose antes con un usuario con privilegios para crear un usuario.
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $response = $this->post('/login', [
            'email' => 'antoniolc11@hotmail.com',
            'password' => '1234',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    //metodo que realiza el registro del usuario.-
    public function test_registration_screen_can_be_rendered(): void
    {

        // Obtener el usuario creado por el seeder (ajusta según tu lógica de seeder)
        $user = User::find(1);

        // Autenticar el usuario en la prueba
        $this->actingAs($user);
        $response = $this->get('/usuarios/create');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        // Obtener el departamento creado por el seeder
        $departamento = Departamento::find(1);

        // Datos de usuario
        $user_data = [
            'nombre' => 'Test User',
            'primer_apellido' => 'Test User',
            'segundo_apellido' => 'Test User',
            'nif' => '45214758L',
            'telefono' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // Crear el usuario
        $response = $this->post('/usuarios', $user_data);

        // Obtener el usuario creado
        $user = User::where('email', 'test@example.com')->first();

        // Asociar al usuario con el departamento a través de la relación muchos a muchos
        $user->departamentos()->attach($departamento);

        // Verificar que la relación existe en la tabla intermedia
        $this->assertDatabaseHas('departamento_user', [
            'user_id' => $user->id,
            'departamento_id' => $departamento->id,
        ]);

        // Verificar que el usuario se redirige a la página de inicio
        $response->assertRedirect(route('users.index'));

        // Asegurarse de que el usuario esté en la base de datos después del registro
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}


//php artisan test --filter RegistroUsuarioTest     lanzar el test
