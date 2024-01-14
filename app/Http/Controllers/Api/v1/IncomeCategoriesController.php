<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IncomeCategories;

class IncomeCategoriesController extends Controller
{
 
    public function index(Request $request)
    {
        $response = IncomeCategories::get();
        return $response;
    }
}
