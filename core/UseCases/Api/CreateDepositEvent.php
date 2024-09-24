<?php

namespace Core\UseCases\Api;

use Core\Models\Deposit;
use Core\Services\Account\Balance;

class CreateDepositEvent
{

    public function handle(Deposit $deposit)
    {
        $account = $deposit->account;

        $event = $account->events()->create([
            'type' => 'deposit',
            'amount' => $deposit->amount
        ]);

        $balance = new Balance($event->account_id);
        $balance->increment($event->amount);

        return response()->json([
            "destination" => [
                "id" => $event->account_id,
                "balance" => $balance->get()
            ]
        ], 201);
    }
}
