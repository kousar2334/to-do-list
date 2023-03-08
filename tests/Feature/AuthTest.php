<?php

namespace Test\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_returns_success_true_when_user_registration_is_successful()
    {
        $response = $this->postJson('/api/v1/user-register', [
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertOk();
        $this->assertArrayHasKey('success', $response->json());
        $this->assertEquals($response->json('success'), true);
    }
    /** @test */
    public function it_returns_success_true_valid_user_credentials_are_passed()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/v1/user-login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertOk();
        $this->assertArrayHasKey('success', $response->json());
        $this->assertEquals($response->json('success'), true);
    }

    /** @test */
    public function it_returns_success_false_when_invalid_user_credentials_are_passed()
    {
        $response = $this->postJson('/api/v1/user-login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertOk();
        $this->assertArrayHasKey('success', $response->json());
        $this->assertEquals($response->json('success'), false);
    }
}
