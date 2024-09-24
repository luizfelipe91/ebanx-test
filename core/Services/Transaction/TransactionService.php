<?php

namespace Core\Services\Transaction;

use Core\Exceptions\TransactionException;
use Core\Models\Contracts\CashEntry;
use Core\Models\Transaction;
use Core\Services\Account\Balance;
use Illuminate\Support\Facades\DB;

class TransactionService
{

    function create(callable $createCashEntry): Transaction
    {
        /** @var Transaction */
        $transaction = DB::transaction(function () use ($createCashEntry) {
            /** @var CashEntry */
            $cashEntry = $createCashEntry();

            $transaction = $cashEntry->transactions()->create([
                'account_id' => $cashEntry->account_id,
                'description' => $cashEntry->getDescription(),
                'amount' => $cashEntry->getAmount()
            ]);

            $transaction->setRelation('owner', $cashEntry);

            return $transaction;
        });

        $balance = new Balance($transaction->account_id);

        if ($transaction->isCashIn()) {
            $balance->increment(abs($transaction->amount));
        } else {
            $balance->decrement(abs($transaction->amount));
        }

        return $transaction;
    }
}
