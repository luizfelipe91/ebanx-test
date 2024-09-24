<?php

namespace Core\UseCases\Api;

use Core\Models\Account;
use Core\Models\Transfer;
use Core\Models\Withdraw;
use Core\Services\Account\Balance;

class CreateTransferEvent
{

    public function handle(Transfer $transfer)
    {
        $account = $transfer->account;
        $destinationAccount = $transfer->destinationAccount;

        $this->createCashOutEvent($account, $transfer);
        $this->createCashInEvent($destinationAccount, $transfer);

        $accountBalance = new Balance($account->id);
        $destinationAccountBalance = new Balance($destinationAccount->id);

        return response()->json([
            "origin" => [
                "id" => strval($transfer->origin),
                "balance" => $accountBalance->get()
            ],
            "destination" => [
                "id" => strval($transfer->destination),
                "balance" => $destinationAccountBalance->get()
            ]
        ], 201);
    }

    private function createCashOutEvent(Account $account, Transfer $transfer)
    {
        $cashOutAmount = abs($transfer->amount) * -1;

        $event = $account->events()->create([
            'type' => 'transfer',
            'amount' => $cashOutAmount
        ]);

        $balance = new Balance($event->account_id);
        $balance->decrement($event->amount);
    }

    private function createCashInEvent(Account $destinationAccount, Transfer $transfer)
    {
        $event = $destinationAccount->events()->create([
            'type' => 'transfer',
            'amount' => $transfer->amount
        ]);

        $balance = new Balance($event->account_id);
        $balance->increment($event->amount);
    }
}
