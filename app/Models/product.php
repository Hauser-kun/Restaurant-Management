<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [
        'name',
        'Mprice',
        'Sprice',
        'description',
        'Status',
        'category_id',
    ];

    protected $casts = [
        'status' => 'boolean', // This will ensure it is treated as a boolean in the database
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
