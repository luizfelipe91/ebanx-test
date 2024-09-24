<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Redis;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        if (app()->environment('testing')) {
            self::clearRedisKeys([
                'account_balance:*'
            ]);
        }
    }

    private static function clearRedisKeys(array $locks_keys)
    {
        $redisPrefix = config('database.redis.options.prefix');
        foreach ($locks_keys as $lock_key_pattern) {
            foreach (Redis::keys($lock_key_pattern) as $key) {
                $rawKey = str($key)->replace($redisPrefix, '')->toString();
                Redis::del($rawKey);
            }
        }
    }
}
