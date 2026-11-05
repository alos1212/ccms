<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_is_public_but_dashboard_is_protected(): void
    {
        $this->get('/admin/login')->assertOk()->assertSee('Bienvenido de nuevo');
        $this->get('/admin/dashboard')->assertRedirect('/admin/login');
    }

    public function test_regular_users_cannot_login_to_the_admin_area(): void
    {
        $user = User::factory()->create(['email' => 'user@example.com', 'password' => 'password']);

        $this->post('/admin/login', [
            'login' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_admin_can_login_and_create_another_admin(): void
    {
        $admin = User::factory()->create(['username' => 'superadmin', 'is_admin' => true]);

        $this->post('/admin/login', [
            'login' => $admin->username,
            'password' => 'password',
        ])->assertRedirect('/admin/dashboard');

        $this->post('/admin/users', [
            'name' => 'Nuevo Admin',
            'username' => 'nuevoadmin',
            'email' => 'nuevo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect('/admin/users');

        $this->assertDatabaseHas('users', ['username' => 'nuevoadmin', 'email' => 'nuevo@example.com', 'is_admin' => true]);
    }
}
