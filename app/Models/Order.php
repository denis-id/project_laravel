<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "user_id",
        "address",
        "phone",
        "status",
        "price",
        "url",
        "payment_method",
        "payment_channel",
        "postal_code",
        "first_name",
        "last_name",
        "email",
        "address_description",
        "city",
        "country",
        "products_name",
        "product_variants_size"
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($order) {
            foreach ($order->orderProducts as $orderProduct) {
                $productVariant = $orderProduct->productVariant;
                if ($productVariant) {
                    $productVariant->increment('stock', $orderProduct->quantity);
                }
            }
        });
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}