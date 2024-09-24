<?php

namespace Core\UseCases\Api;

use Core\Models\Withdraw;
use Core\Services\Account\Balance;

class CreateWithdrawEvent
{

    public function handle(Withdraw $withdraw)
    {
        $account = $withdraw->account;

        $withdrawAmount = abs($withdraw->amount) * -1;

        $event = $account->events()->create([
            'type' => 'deposit',
            'amount' => $withdrawAmount
        ]);

        $balance = new Balance($event->account_id);
        $balance->decrement($event->amount);

        return response()->json([
            "origin" => [
                "id" => strval($event->account_id),
                "balance" => $balance->get()
            ]
        ], 201);
    }
}
