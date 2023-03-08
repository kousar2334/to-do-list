<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Todo\TodoList;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_return_true_when_task_is_created_successfully()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $headers = [
            'AUTHORIZATION' => 'Bearer ' . $token
        ];

        $list = TodoList::create(
            [
                'name' => 'test list',
                'user_id' => $user->id
            ]
        );

        $response = $this->postJson('/api/v1/store-task', [
            'name' => 'test to do list',
            'todo_list_id' => $list->id
        ], $headers);
        $response->assertOk();
        $this->assertArrayHasKey('success', $response->json());
        $this->assertEquals($response->json('success'), true);
    }

    /** @test */
    public function it_returns_an_error_when_invalid_user_token_passed_to_create_task()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $token = 'invalid token';
        $headers = [
            'AUTHORIZATION' => 'Bearer ' . $token
        ];

        $list = TodoList::create(
            [
                'name' => 'test list',
                'user_id' => $user->id
            ]
        );

        $response = $this->postJson('/api/v1/store-task', [
            'name' => 'test to do list',
            'todo_list_id' => $list->id
        ], $headers);
        $response->assertStatus(401);
    }
}
