<?php

namespace Core\UseCases\Api;

use Core\DTO\AccountDTO;
use Core\Models\Account;
use Core\Services\Account\Balance;

class FetchBalance
{

    public function handle(AccountDTO $accountDTO)
    {
        $account = Account::find($accountDTO->getId());

        if (!$account) {
            return response()->json(0, 404);
        }

        $balance = new Balance($account->id);
        return $balance->get();
    }
}
