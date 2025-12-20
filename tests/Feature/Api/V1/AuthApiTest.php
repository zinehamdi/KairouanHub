<?php

namespace Tests\Feature\Api\V1;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_login_and_access_protected_endpoint(): void
    {
        $registerPayload = [
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $register = $this->postJson('/api/v1/auth/register', $registerPayload);
        $register->assertStatus(201)
            ->assertJsonStructure(['data' => ['user' => ['id', 'email'], 'token']]);

        $login = $this->postJson('/api/v1/auth/login', [
            'email' => $registerPayload['email'],
            'password' => $registerPayload['password'],
        ]);
        $login->assertStatus(200)
            ->assertJsonStructure(['data' => ['user' => ['id'], 'token']]);

        $token = $login->json('data.token');

        $protected = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/me');
        $protected->assertStatus(200)
            ->assertJsonPath('data.email', $registerPayload['email']);
    }
}
