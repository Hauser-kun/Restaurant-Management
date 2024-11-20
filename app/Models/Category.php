<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'restaurant_id',
        'status'
    ];

    public function restaurant()
{
    return $this->belongsTo(Restaurant::class);
}
}
