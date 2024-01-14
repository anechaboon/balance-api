<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incomes;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'password' => ['required'],
        ]);

        $credentials['password'] = base64_decode($request->input('password'));

        return $credentials;
    }

 
    public function test(Request $request)
    {
        $response = DB::table('product');
        return $response->get();
    }

    public function index(Request $request)
    {
        $response = Incomes::select([
            'incomes.*',
            DB::raw('income_categories.name as type_name')
        ])
        ->join('income_categories','incomes.income_category_id','income_categories.id');

        if($request->sort){
            $response->orderBy('incomes.id', $request->sort);
        }

        $response->with('user');
        
        return $response->get();
    }

    public function create()
    {

        try {

            DB::beginTransaction();

            $payload = request()->all();
            $payload['created_date'] = date('Y-m-d H:i:s');
            $payload['updated_date'] = date('Y-m-d H:i:s');
            $payload['status'] = 1;
            $res = Incomes::create($payload);

            $amount = $res['amount'];

            Wallet::where(['id' => $payload['wallet_id']])->increment('balance', $amount);

            $user = User::find($res['user_id']);
            $user->income = $user->income + $amount;
            $user->balance = $user->balance + $amount;
            $user->updated_date = date('Y-m-d H:i:s');
            $user->save();

            DB::commit();

            return $res;
            
        } catch (Exception $e) {

            DB::rollBack();

            return $e->getMessage();
        }
       
    }
}
