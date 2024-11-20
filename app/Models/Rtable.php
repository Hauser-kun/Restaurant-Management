<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rtable extends Model
{
    protected $fillable = [
        'name',
        'capacity',
        'available',
        'restaurant_id'
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}
