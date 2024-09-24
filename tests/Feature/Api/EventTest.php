<?php

namespace Tests\Feature;

use Core\Models\Account;
use Core\Services\Account\Balance;
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

    public function test_it_can_deposit_into_an_existing_account(): void
    {
        $account = Account::factory()->create();

        $balance = new Balance($account->id);
        $balance->increment(10);

        $response = $this->postJson('/api/event', [
            "type" => "deposit",
            "destination" => strval($account->id),
            "amount" => 10
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'destination' => [
                'id' => $account->id,
                'balance' => 20
            ]
        ]);
    }

    public function test_it_cant_withdraw_from_non_existing_account(): void
    {
        $response = $this->postJson('/api/event', [
            "type" => "withdraw",
            "origin" => "200",
            "amount" => 10
        ]);

        $response->assertStatus(404);
    }

    public function test_it_can_withdraw_from_existing_account(): void
    {
        $account = Account::factory()->create();

        $balance = new Balance($account->id);
        $balance->increment(20);

        $response = $this->postJson('/api/event', [
            "type" => "withdraw",
            "origin" => strval($account->id),
            "amount" => 5
        ]);

        dd($response->json());
    }
}
