<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'officeName',
        'email',
        'contact',
        'image',
        'pan',
        'vatPer',
    ];
}
