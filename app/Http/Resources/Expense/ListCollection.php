<?php

namespace App\Http\Resources\Expense;

use App\Http\Resources\MainCollection;
use App\Models\Expenses;

class ListCollection extends MainCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'data' => $this->collection,
        ];
    }
}
