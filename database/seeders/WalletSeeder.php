<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wallet;


class WalletSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
      Wallet::firstOrCreate([ 'title' => 'เงินกิน', 'balance' => 0, 'default_expense_cate_id' => 1]);
      Wallet::firstOrCreate([ 'title' => 'เงินใช้', 'balance' => 0, 'default_expense_cate_id' => 2]);
      Wallet::firstOrCreate([ 'title' => 'เงินเก็บ', 'balance' => 0]);
   }
}

