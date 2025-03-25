<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        "order_id",
        "product_variant_id",
        "quantity",
        "variant_name",
        "price"
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function order() 
    {
        return $this->belongsTo(Order::class);
    }
}