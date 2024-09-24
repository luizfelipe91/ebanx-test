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
        $response = $this->postJson('/event', [
            "type" => "deposit",
            "destination" => "100",
            "amount" => 10
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'destination' => [
                'id' => "100",
                'balance' => 10
            ]
        ]);
    }

    public function test_it_can_deposit_into_an_existing_account(): void
    {
        $account = Account::factory()->create();

        $balance = new Balance($account->id);
        $balance->increment(10);

        $response = $this->postJson('/event', [
            "type" => "deposit",
            "destination" => strval($account->id),
            "amount" => 10
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'destination' => [
                'id' => strval($account->id),
                'balance' => 20
            ]
        ]);
    }

    public function test_it_cant_withdraw_from_non_existing_account(): void
    {
        $response = $this->postJson('/event', [
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

        $response = $this->postJson('/event', [
            "type" => "withdraw",
            "origin" => strval($account->id),
            "amount" => 5
        ]);

        $response->assertJsonFragment([
            'origin' => [
                'id' => strval($account->id),
                'balance' => 15
            ]
        ]);
    }

    public function test_it_cant_transfer_from_non_existing_account(): void
    {
        $response = $this->postJson('/event', [
            "type" => "transfer",
            "origin" => "200",
            "amount" => 15,
            "destination" => "300"
        ]);

        $response->assertStatus(404);
    }

    public function test_it_can_transfer_from_existing_account(): void
    {
        $account = Account::factory()->create();

        $balance = new Balance($account->id);
        $balance->increment(15);

        $response = $this->postJson('/event', [
            "type" => "transfer",
            "origin" => strval($account->id),
            "amount" => 15,
            "destination" => "300"
        ]);

        $response->assertJsonFragment([
            "origin" => [
                "id" => strval($account->id),
                "balance" => 0
            ],
            "destination" => [
                "id" => "300",
                "balance" => 15
            ]
        ]);
    }
}
