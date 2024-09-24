<?php

namespace Tests\Feature;

use Core\Models\Account;
use Core\Services\Account\Balance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_it_cant_fetch_account_balance_for_non_existing_account(): void
    {
        $response = $this->getJson('/balance?account_id=1234');

        $response->assertStatus(404);
    }

    public function test_it_can_fetch_account_balance(): void
    {
        $account = Account::factory()->create();

        $balance = new Balance($account->id);
        $balance->increment(10);

        $response = $this->getJson("/balance?account_id=" . $account->id);

        $response->assertStatus(200);
        $this->assertEquals($response->json(), 10);
    }
}
