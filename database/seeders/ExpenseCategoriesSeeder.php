<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategories;


class ExpenseCategoriesSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
        ExpenseCategories::firstOrCreate([ 'title' => 'food', 'name' => 'ค่ากิน', 'icon' => 'fa-solid fa-utensils']);
        ExpenseCategories::firstOrCreate([ 'title' => 'utensils', 'name' => 'ของใช้', 'icon' => 'fa-solid fa-box-open']);
        ExpenseCategories::firstOrCreate([ 'title' => 'electric_bill', 'name' => 'ค่าไฟ', 'icon' => 'fa-solid fa-plug']);
        ExpenseCategories::firstOrCreate([ 'title' => 'desert', 'name' => 'ขนม', 'icon' => 'fa-solid fa-ice-cream']);
   }
}

