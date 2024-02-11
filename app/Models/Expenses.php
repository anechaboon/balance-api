<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\{ExpenseCategories, User, Wallet};

class Expenses extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['wallet_id', 'expense_category_id', 'memo', 'amount', 'user_id', 'status', 'created_at', 'updated_at'];

    // protected $appends = ['user'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable('expenses');
    }

    // public function getUserAttribute()
    // {
    //     $user = User::select(['full_name','image_url'])->where('id',$this->user_id)->first();
    //     return [
    //         'name' => $user->full_name,
    //         'image_url' => $user->image_url,
    //     ];
    // }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function expense_category()
    {
        return $this->hasOne(ExpenseCategories::class, 'id', 'expense_category_id');
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'id', 'wallet_id');
    }
}
