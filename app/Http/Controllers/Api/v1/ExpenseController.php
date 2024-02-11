<?php

namespace App\Http\Controllers\Api\v1;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Helper\Helpers;

class ExpenseController extends Controller
{
 
    public function index(Request $request)
    {
        $response = Expenses::select([
            'expenses.*',
            DB::raw('expense_categories.name as type_name')
        ])
        ->join('expense_categories','expenses.expense_category_id','expense_categories.id');

        if($request->sort){
            $response->orderBy('expenses.id', $request->sort);
        }
        $response->with('user');
        
        return $response->get();
    }

    public function create()
    {
        try {

            DB::beginTransaction();

            $payload = request()->all();
            $payload['created_at'] = date('Y-m-d H:i:s');
            $payload['updated_at'] = date('Y-m-d H:i:s');
            $payload['status'] = 1;
            
            Helpers::createExpense($payload);

            DB::commit();

            return ['status' => 200];
            
        } catch (Exception $e) {

            DB::rollBack();

            return $this->error($e->getMessage());
        }
       
    }
}
