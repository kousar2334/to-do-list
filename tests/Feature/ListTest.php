<?php

namespace Test\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_return_true_when_list_is_created_successfully()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $headers = [
            'AUTHORIZATION' => 'Bearer ' . $token
        ];

        $response = $this->postJson('/api/v1/store-list', [
            'name' => 'test to do list',
        ], $headers);
        $response->assertOk();
        $this->assertArrayHasKey('success', $response->json());
        $this->assertEquals($response->json('success'), true);
    }

    /** @test */
    public function it_returns_an_error_when_invalid_user_token_passed_to_create_list()
    {
        $token = 'in_valid_token';
        $headers = [
            'AUTHORIZATION' => 'Bearer ' . $token
        ];

        $response = $this->postJson('/api/v1/store-list', [
            'name' => 'test to do list',
        ], $headers);
        $response->assertStatus(401);
    }
}
