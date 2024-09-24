<?php

namespace Core\UseCases\Api;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;

class ResetState
{

    public function handle()
    {
        Redis::flushall();
        Artisan::call('migrate:fresh');

        return 'OK';
    }
}
