<?php

namespace Tests\Unit;

use Core\ValueObjects\Amount;
use Core\ValueObjects\Exceptions\InvalidValueException;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_valid_amount(): void
    {
        new Amount(100);
        new Amount(1);
        new Amount(0.1);
        new Amount(0.01);
        new Amount(100000);

        $this->expectException(InvalidValueException::class);
        new Amount(0.0001);
    }
}
