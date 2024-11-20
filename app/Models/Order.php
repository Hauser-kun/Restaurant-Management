<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'table_id',
        'total',
        'vat',
        'discountTotal',
        'customerName',
        'customerContact',
    ];

    public function table(){
       return $this->belongsTo(Rtable::class,'table_id');
    }


}
