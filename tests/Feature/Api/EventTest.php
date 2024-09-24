<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_it_can_create_a_account_with_initial_balance(): void
    {
        $response = $this->postJson('/api/event', [
            "type" => "deposit",
            "destination" => "100",
            "amount" => 10
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'destination' => [
                'id' => 100,
                'balance' => 10
            ]
        ]);
    }
}
