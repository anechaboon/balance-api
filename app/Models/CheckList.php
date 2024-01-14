<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckList extends Model
{
    use HasFactory;

    public $timestamps = false;

    // protected $hidden = ['created_date', 'updated_date'];

    protected $fillable = ['wallet_id','memo', 'amount', 'state', 'checked','user_id', 'status', 'created_date'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable('check_list');
    }

}
