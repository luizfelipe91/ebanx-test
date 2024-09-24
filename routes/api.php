<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/balance', [AccountController::class, 'fetchBalance']);
Route::post('/event', [EventController::class, 'createEvent']);
