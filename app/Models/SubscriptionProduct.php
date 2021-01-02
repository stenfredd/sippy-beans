<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionProduct extends Model
{
    protected $fillable = [
        'subscription_id',
        'product_id',
        'variant_id',
        'price',
        'quantity',
        'status'
    ];

    public function subscription()
    {
        return $this->hasOne("App\Models\Subscription", "id", "subscription_id");
    }

    public function product()
    {
        return $this->hasOne("App\Models\Product", "id", "product_id");
    }
}
