<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenses_Category extends Model
{
    protected $fillable = [
        'name',
        'restaurant_id',
        'details',
        'status'

    ];

    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }
}
