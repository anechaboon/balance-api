<?php
 
namespace App\Http\Controllers\Auth;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Expenses;
use App\Models\Incomes;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;


class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        
    }

}