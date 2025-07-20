<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'pharma_id',
        'quantity',
        'price',
        'total'
    ];
    
    public function pharma()
    {
        return $this->belongsTo(Pharma::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
