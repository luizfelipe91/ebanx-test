<?php

namespace Core\UseCases\Api\Interfaces;

use Core\DTO\EventDTO;

interface EventInterface
{
    public function perform(EventDTO $eventDTO);
}
