<?php

namespace Core\UseCases\Api;

use Core\DTO\EventDTO;
use Core\Models\Deposit;
use Core\Models\Event;
use Core\Models\Transfer;
use Core\Models\Withdraw;
use Exception;

class CreateEvent
{

    public function handle(EventDTO $eventDTO)
    {
        $eventType = $this->selectEventByType($eventDTO->getType());

        $eventPerformed = $eventType->perform($eventDTO);

        if (!$eventPerformed) {
            return response()->json(0, 404);
        }

        $event = $this->createEventByType($eventPerformed);

        return $event;
    }

    private function selectEventByType(string $event)
    {
        if ($event === 'deposit') {
            return new CreateDeposit;
        }

        if ($event === 'withdraw') {
            return new CreateWithdraw;
        }

        if ($event === 'transfer') {
            return new CreateTransfer;
        }

        throw new Exception("Invalid event type");
    }

    private function createEventByType($eventPerformed)
    {
        if ($eventPerformed instanceof Deposit) {
            $event = new CreateDepositEvent;
            return $event->handle($eventPerformed);
        }

        if ($eventPerformed instanceof Withdraw) {
            $event = new CreateWithdrawEvent;
            return $event->handle($eventPerformed);
        }

        if ($eventPerformed instanceof Transfer) {
            $event = new CreateTransferEvent;
            return $event->handle($eventPerformed);
        }

        throw new Exception("Invalid event type");
    }
}
