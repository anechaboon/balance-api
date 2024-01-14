<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\{IncomeCategories, User, Wallet};
class Incomes extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = ['created_date', 'updated_date'];

    protected $fillable = ['wallet_id', 'income_category_id', 'memo', 'amount', 'user_id', 'status', 'created_date', 'updated_date'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable('incomes');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function income_category()
    {
        return $this->hasOne(IncomeCategories::class, 'id', 'expense_category_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'id', 'wallet_id');
    }
}
