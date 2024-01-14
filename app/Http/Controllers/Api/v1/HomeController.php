<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expenses;
use App\Models\Incomes;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Expense\{
    ListCollection,
};

class HomeController extends Controller
{
    public function getBalance(Request $request)
    {
        return Wallet::find($request->wallet_id);
        // $balances = User::get();
        // $balances = User::select([
        //     'users.*',
        //     'wallet.balance as wallet_balance'
        // ])->where

        // $expense = 0;
        // $income = 0;
        // $balance = 0;
        // foreach($balances as $item){
        //     if($request->user_id == $item->id){
        //         $user = $item;
        //     }
        //     $expense += $item->expense;
        //     $income += $item->income;
        //     $balance += $item->balance;
        // }
        // if($income - $expense == $balance){
        //     return $user;
        // }
        // return false;
        // return [
        //     '$income' => $income,
        //     '$expense' => $expense,
        //     '$balance' => $balance,
        // ];

    }
 
    public function getIncomeAndExpense(Request $request)
    {
        $incomeList = Incomes::select([
            'incomes.*',
            DB::raw('income_categories.name as type_name')
        ])
        ->join('income_categories','incomes.income_category_id','income_categories.id')
        ->where('incomes.status',1);

        $incomeList->with('user');

        if($request->startDate && $request->endDate){
            $incomeList->whereBetween('incomes.created_date', [$request->startDate,$request->endDate]);
        }
            
        if($request->sort){
            $incomeList->orderBy('incomes.id', $request->sort);
        }

        $expenseList = Expenses::select([
            'expenses.*',
            DB::raw('expense_categories.name as type_name')
        ])
        ->join('expense_categories','expenses.expense_category_id','expense_categories.id')
        ->where('expenses.status',1);
        $expenseList->with('user');


        if($request->sort){
            $expenseList->orderBy('incomes.id', $request->sort);
        }

        $res1 = $incomeList->get();

        $res2 = $expenseList->get();

        $res3 = $res1->concat($res2)->sortByDesc('created_date');
        $newCollection = [];
        foreach($res3 as $item){
            $newCollection[] = $item;
        }

        return $newCollection;


    }

    public function report(Request $request)
    {
        $startDate = date('Y-m-d 00:00:00', strtotime('-15 day'));
        $endDate = date('Y-m-d 00:00:00', strtotime('+14 day'));

        // $startDate = date('Y-m-d 00:00:00');
        // $endDate = date('Y-m-d 00:00:00', strtotime('+1 month'));

        if($request->start_date && $request->end_date){
            $startDate = $request->start_date;
            $endDate = $request->end_date;
        }

        $expenseList = Expenses::select([
            'expenses.expense_category_id',
            'expenses.wallet_id',
            'expenses.status',
            DB::raw('sum(amount) as sum'),
        ])
            ->whereBetween('created_date',[$startDate,$endDate])
            ->where([
                'wallet_id' => $request->wallet_id
            ])
            ->groupBy('expense_category_id')
            ->selectRaw('sum(amount) as amount');

        $expenseList->with([
            'expense_category',
        ]);

        $wallet = Wallet::select('balance')->where('id',$request->wallet_id)->first();

        return [
            'data' => $expenseList->get(),
            'wallet' => $wallet,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
        // return new ListCollection($expenseList->get());
    }

}
