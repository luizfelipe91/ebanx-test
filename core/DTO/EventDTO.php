<?php

namespace Core\DTO;

use Core\ValueObjects\Amount;

class EventDTO
{
    public string $type;
    public float $amount = 0;
    public ?string $destination = "";
    public ?string $origin = "";

    public function __construct()
    {
    }

    function getType(): string
    {
        return $this->type;
    }

    function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    function getAmount(): float
    {
        return $this->amount;
    }

    function setAmount(Amount $amount): self
    {
        $this->amount = $amount->getValue();
        return $this;
    }

    function getDestination(): float
    {
        return $this->destination;
    }

    function setDestination(string $destination): self
    {
        $this->destination = $destination;
        return $this;
    }

    function getOrigin(): float
    {
        return $this->origin;
    }

    function setOrigin(string $origin): self
    {
        $this->origin = $origin;
        return $this;
    }
}
