<?php

namespace Core\ValueObjects;

use Core\ValueObjects\Exceptions\InvalidValueException;

class Amount
{
    private float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $this->validate($amount);
    }

    private function validate(float $amount)
    {
        if (is_float($amount) && $amount >= 0.001 && $amount <= 9999999.999) {
            return $amount;
        }

        throw new InvalidValueException("Invalid amount");
    }

    public function getValue(): float
    {
        return $this->amount;
    }

    public function equals(Amount $other)
    {
        return $this->amount === $other->getValue();
    }
}
