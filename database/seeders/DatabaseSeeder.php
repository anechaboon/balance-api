<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\{ExpenseCategoriesSeeder, IncomeCategoriesSeeder, WalletSeeder};

class DatabaseSeeder extends Seeder
{

    public static function seedersClass(): array
    {
        return [
            IncomeCategoriesSeeder::class,
            ExpenseCategoriesSeeder::class,
            WalletSeeder::class,
        ];
    }
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call($this->seedersClass());
    }
}
