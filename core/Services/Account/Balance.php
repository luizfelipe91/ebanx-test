<?php

namespace Core\Services\Account;

use Illuminate\Support\Facades\Redis;

class Balance
{
    public function __construct(public int $id)
    {
    }

    public function increment(float $amount): float
    {
        return $this->performIncr(abs($amount));
    }

    public function decrement(float $amount): float
    {
        return $this->performIncr(-abs($amount));
    }

    public function get(): float
    {
        return (float) Redis::get($this->key());
    }

    private function key()
    {
        return "account_balance:$this->id";
    }

    private function performIncr(float $amount): float
    {
        $balance = Redis::incrByFloat($this->key(), $amount);

        return round($balance, 2);
    }
}
