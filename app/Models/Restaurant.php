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


    public function categories () {
        return $this->hasMany(Category::class);
    } 

    public function products () {
        return $this->hasManyThrough(Product::class, Category::class);
    } 
}
