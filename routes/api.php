<?php

use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;

Route::post('/event', [EventController::class, 'createEvent']);
