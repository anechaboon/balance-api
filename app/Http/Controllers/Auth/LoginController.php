<?php
 
namespace App\Http\Controllers\Auth;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Expenses;
use App\Models\Incomes;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;


class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['password'] = base64_decode($request->input('password'));
        if (Auth::attempt($credentials)) {

            $totalIncome = Incomes::where('status',1)->sum('amount');
            $totalExpense = Expenses::where('status',1)->sum('amount');

            $user = User::where('email',$credentials['email'])->first();

            if(($totalIncome == $user->income) && ($totalExpense == $user->expense) && ($totalIncome - $totalExpense == $user->balance)){
            }else{
                $balance = floatval($totalIncome - $totalExpense);
                $user->balance = $balance;
                $user->save();
            }
            return $user;

        }
 
        return response()->json(['error' => 'The provided credentials do not match our records.'], 401);

    }


    public function decryptPassword($encryptedData)
    {
        $passphrase = '1234567890123456';
        $blocksize = 16; // ใช้ AES-128 ซึ่งมี Block Size คือ 16 บิต

        $decryptedData = Crypt::decryptString($encryptedData);

        // ต้องใช้ PKCS7 unpadding เพื่อเอา Padding ออก
        $unpaddedData = $this->pkcs7_unpad($decryptedData, $blocksize);

        return $unpaddedData;
    }

    // ฟังก์ชันสำหรับ PKCS7 unpadding
    function pkcs7_unpad($data, $blocksize)
    {
        $padLength = ord($data[strlen($data) - 1]);
        return substr($data, 0, -$padLength);
    }

}