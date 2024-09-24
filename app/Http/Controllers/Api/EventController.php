<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Core\DTO\EventDTO;
use Core\UseCases\Api\CreateEvent;
use Core\ValueObjects\Amount;
use Illuminate\Http\Request;

class EventController extends Controller
{
    function createEvent(Request $request, CreateEvent $useCase)
    {
        $data = $request->validate([
            'type' => 'required|in:deposit,withdraw,transfer',
            'destination' => 'nullable|string',
            'origin' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $amount = new Amount($data['amount']);

        $eventDTO = new EventDTO();
        $eventDTO->setType($data['type']);
        $eventDTO->setDestination(data_get($data, 'destination', ""));
        $eventDTO->setOrigin(data_get($data, 'origin', ""));
        $eventDTO->setAmount($amount);

        $event = $useCase->handle($eventDTO);

        return $event;
    }
}
