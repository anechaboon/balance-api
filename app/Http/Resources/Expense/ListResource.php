<?php

namespace App\Http\Resources\Expense;

use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'expense_category_id' => $this->expense_category_id,
            'memo' => $this->memo,
            'amount' => $this->amount,
            'user_id' => $this->user_id,
            'wallet_id' => $this->wallet_id,
            'status' => $this->status,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'expense_category_name' => $this->when($this->expense_category != null, function () {
                return $this->expense_category->title;
            }, ""),
        ];
    }
}
