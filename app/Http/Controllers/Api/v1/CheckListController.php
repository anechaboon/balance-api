<?php

namespace App\Http\Controllers\Api\v1;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CheckList;
use App\Models\Expenses;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use App\Helper\Helpers;

class CheckListController extends Controller
{
 
    public function index(Request $request)
    {
        $response = CheckList::select([
            'check_list.*',
        ]);

        if($request->walletId){
            $response->where('check_list.wallet_id', $request->walletId);
        }
        if($request->sort){
            $response->orderBy('check_list.created_at', $request->sort);
        }
        
        return $response->get();
    }

    public function create()
    {
        try {

            DB::beginTransaction();

            $payloads = request()->all();

            $resultCollection = collect($payloads['check_list']);
            if(sizeof($resultCollection) == 0){
                CheckList::where('id','>=',1)->delete();

            }else{
                $allWalletId = array_unique($resultCollection->unique()->pluck('wallet_id')->toArray());

                CheckList::whereIn('wallet_id',$allWalletId)->delete();

                foreach($payloads['check_list'] as $payload){
                    
                    unset($payload['id']);
                    $payload['created_at'] = date('Y-m-d H:i:s');
                    $payload['updated_at'] = date('Y-m-d H:i:s');
                    $payload['status'] = 1;
                    $payload['wallet_id'] = $payload['wallet_id'];
                    $payload['checked'] = $payload['checked'] == true ? 1 : 0;
                    // return $payload;
                    CheckList::create($payload);
                }
            }

            
            
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            // return $this->error($e->getMessage());
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function buy()
    {
        try {

            DB::beginTransaction();

            $payloads = request()->all();
            
            $wallet = Wallet::find($payloads['wallet_id']);
            foreach($payloads['check_list'] as $payload){
                CheckList::where('id',$payload['id'])->update([
                    'status' => 2
                ]);
                unset($payload['id']);
                unset($payload['checked']);
                $payload['created_at'] = date('Y-m-d H:i:s');
                $payload['updated_at'] = date('Y-m-d H:i:s');
                $payload['status'] = 1;
                $payload['wallet_id'] = $payloads['wallet_id'];
                $payload['expense_category_id'] = $wallet->default_expense_cate_id;
                Helpers::createExpense($payload);
            }
            
            DB::commit();

            return ['status' => 200];

        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            // return $this->error($e->getMessage());
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }
}
