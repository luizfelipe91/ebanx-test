<?php

namespace Core\UseCases\Api;

use Core\DTO\EventDTO;
use Core\Models\Account;
use Core\Models\Deposit;
use Core\Models\Withdraw;
use Core\UseCases\Api\Interfaces\EventInterface;

class CreateWithdraw implements EventInterface
{

    public function perform(EventDTO $eventDTO)
    {
        $account = Account::findOrFail($eventDTO->origin);

        $withdraw = new Withdraw();
        $withdraw->amount = $eventDTO->getAmount();
        $withdraw->origin = $account->id;
        $withdraw->save();

        return $withdraw;
    }
}
