<?php

namespace Core\UseCases\Api;

use Core\DTO\EventDTO;
use Core\Models\Account;
use Core\Models\Transfer;
use Core\UseCases\Api\Interfaces\EventInterface;

class CreateTransfer implements EventInterface
{

    public function perform(EventDTO $eventDTO)
    {
        $account = Account::find($eventDTO->origin);

        if (!$account) {
            return false;
        }

        $destinationAccount = $this->checkDestinationAccount($eventDTO->destination);

        $transfer = new Transfer;
        $transfer->amount = $eventDTO->getAmount();
        $transfer->origin = $account->id;
        $transfer->destination = $destinationAccount->id;
        $transfer->save();

        return $transfer;
    }

    private function checkDestinationAccount(string $destination)
    {
        $destinationAccount = Account::find($destination);

        if (!$destinationAccount) {
            $destinationAccount = new Account;
            $destinationAccount->id = $destination;
            $destinationAccount->save();
        }

        return $destinationAccount;
    }
}
