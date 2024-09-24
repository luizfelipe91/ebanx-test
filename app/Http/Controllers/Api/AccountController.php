<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Core\DTO\AccountDTO;
use Core\UseCases\Api\FetchBalance;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    function fetchBalance(Request $request, FetchBalance $useCase)
    {
        $data = $request->validate([
            'account_id' => 'required'
        ]);

        $accountDTO = new AccountDTO;
        $accountDTO->setId($data['account_id']);

        $balance = $useCase->handle($accountDTO);

        return $balance;
    }
}
