<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Core\UseCases\Api\ResetState;

class ResetController extends Controller
{
    function reset(ResetState $useCase)
    {
        return $useCase->handle();
    }
}
