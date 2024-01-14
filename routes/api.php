<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{HomeController, WalletController, CheckListController, ExpenseCategoriesController, IncomeCategoriesController, ExpenseController, IncomeController};
use App\Http\Controllers\Auth\{LoginController, RegisterController};


Route::group([
    'prefix' => 'v1/service'
], function () {

    Route::post('register', [RegisterController::class, 'create']);
    Route::post('login', [LoginController::class, 'authenticate']);

    Route::prefix('income')->group(function () {
        Route::get('/', [IncomeController::class, 'index']);
        Route::post('/', [IncomeController::class, 'create']);
        Route::prefix('{incomeId}')->group(function () {
        });
    });

    Route::prefix('expense')->group(function () {
        Route::get('/', [ExpenseController::class, 'index']);
        Route::post('/', [ExpenseController::class, 'create']);
        Route::prefix('{incomeId}')->group(function () {
        });
    });

    Route::prefix('check-list')->group(function () {
        Route::get('/', [CheckListController::class, 'index']);
        Route::post('/', [CheckListController::class, 'create']);
        Route::post('/buy', [CheckListController::class, 'buy']);
    });

    Route::prefix('incomeCategories')->group(function () {
        Route::get('/', [IncomeCategoriesController::class, 'index']);
        Route::prefix('{incomeCateId}')->group(function () {
        });
    });

    Route::prefix('expenseCategories')->group(function () {
        Route::get('/', [ExpenseCategoriesController::class, 'index']);
        Route::prefix('{expenseCateId}')->group(function () {
        });
    });

    Route::prefix('home')->group(function () {
        Route::get('/getIncomeAndExpense', [HomeController::class, 'getIncomeAndExpense']);
        Route::get('/getBalance', [HomeController::class, 'getBalance']);
        Route::prefix('/report')->group(function () {
            Route::post('/', [HomeController::class, 'report']);
        });
        
    });

    Route::prefix('wallet')->group(function () {
        Route::get('/', [WalletController::class, 'index']);
        Route::prefix('{walletId}')->group(function () {
            Route::get('/', [WalletController::class, 'getById']);
        });
    });
    

    

});

