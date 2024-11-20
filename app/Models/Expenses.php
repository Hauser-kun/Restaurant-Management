<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    protected $fillable = [
        'title',
        'info',
        'remark',
        'amount',
        'expenses_category_id'
       
    ];

    public function categoryExpenses() {
        return $this->belongsTo(Expenses_Category::class, 'expenses_category_id');

    }
}
