<?php

use Illuminate\Support\Facades\Route;

Route::get('/balance', [AccountController::class, 'fetchBalance']);
