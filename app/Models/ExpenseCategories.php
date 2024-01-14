<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExpenseCategories extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = ['created_date', 'updated_date'];

    protected $fillable = ['title', 'name', 'icon', 'user_id', 'status', 'created_date', 'updated_date'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable('expense_categories');
    }

}
