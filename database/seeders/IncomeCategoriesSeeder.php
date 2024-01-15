<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IncomeCategories;


class IncomeCategoriesSeeder extends Seeder
{
   /**
    * Run the database seeds.
    *
    * @return void
    */
   public function run()
   {
        IncomeCategories::firstOrCreate([ 'title' => 'salary', 'name' => 'เงินเดือน', 'icon' => 'fa-solid fa-money-bills']);
   }
}

