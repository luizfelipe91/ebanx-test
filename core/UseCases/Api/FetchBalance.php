<?php

namespace Core\UseCases\Api;

use Core\DTO\AccountDTO;
use Core\Models\Account;
use Core\Services\Account\Balance;

class FetchBalance
{

    public function handle(AccountDTO $accountDTO)
    {
        $account = Account::findOrFail($accountDTO->getId());

        $balance = new Balance($account->id);
        return $balance->get();
    }
}
