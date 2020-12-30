<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'stripe_subscription_id',
        'subscription_id',
        'product_id',
        'variant_id',
        'grind_id',
        'equipment_id',
        'quantity',
        'amount',
        'subtotal',
        'is_cancelled'
    ];

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function variant() {
        return $this->hasOne(Variant::class, 'id', 'variant_id');
    }

    public function equipment() {
        return $this->hasOne(Equipment::class, 'id', 'equipment_id');
    }

    public function subscription() {
        return $this->hasOne(Subscription::class, 'id', 'subscription_id');
    }
}
