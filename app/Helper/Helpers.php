<?php
namespace App\Helper;
use App\Models\Expenses;
use App\Models\Wallet;
use App\Models\User;

class Helpers
{
    public function createExpense($payload)
    {
        $res = Expenses::create($payload);

        $amount = $res['amount'];

        Wallet::where(['id' => $payload['wallet_id']])->decrement('balance', $amount);

        $user = User::find($res['user_id']);
        $user->expense = $user->expense + $amount;
        $user->balance = $user->balance - $amount;
        $user->updated_date = date('Y-m-d H:i:s');
        $user->save();
    }
}

