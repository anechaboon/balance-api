<?php

namespace App\Http\Controllers\Api\v1;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    public function index(Request $request)
    {
        $response = Wallet::select([
            'wallet.*',
        ]);
        if($request->sort){
            $response->orderBy('wallet.id', $request->sort);
        }
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
            $res = Wallet::create($payload);

            DB::commit();

            return $res;
            
        } catch (Exception $e) {

            DB::rollBack();

            return $e->getMessage();
        }
       
    }

    public function getById()
    {
        return Wallet::find(request()->route('walletId'));
    }

    
}
