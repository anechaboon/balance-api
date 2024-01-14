<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseCategories;

class ExpenseCategoriesController extends Controller
{
 
    public function index(Request $request)
    {
        $response = ExpenseCategories::get();
        return $response;
    }
}
