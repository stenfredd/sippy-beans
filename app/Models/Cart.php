<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_id',
        'equipment_id',
        'product_id',
        'variant_id',
        'grind_id',
        'quantity'
    ];

    protected $hidden = ['grind'];

    public function variant()
    {
        return $this->hasOne(Variant::class, 'id', 'variant_id');
    }

    public function grind()
    {
        return $this->hasOne(Grind::class, 'id', 'grind_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class, 'id', 'equipment_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'id', 'subscription_id');
    }
}
