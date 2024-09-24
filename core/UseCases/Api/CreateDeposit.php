<?php

namespace Core\UseCases\Api;

use Core\DTO\EventDTO;
use Core\Models\Account;
use Core\Models\Deposit;
use Core\Services\Account\AccountService;
use Core\UseCases\Api\Interfaces\EventInterface;

class CreateDeposit implements EventInterface
{

    public function perform(EventDTO $eventDTO)
    {
        $account = $this->checkAccount($eventDTO->getDestination());

        $deposit = new Deposit;
        $deposit->amount = $eventDTO->getAmount();
        $deposit->destination = $account->id;
        $deposit->save();

        return $deposit;
    }

    private function checkAccount(int $destination)
    {
        $account = Account::find($destination);

        if (!$account) {
            $account = new Account;
            $account->id = $destination;
            $account->save();
        }

        return $account;
    }
}
