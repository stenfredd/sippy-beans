<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'subscription_id',
        'price_id',
        'product_id',
        'image_url',
        'title',
        'description',
        'price',
        'type',
        'grind_ids',
        'status'
    ];

    public function getImageUrlAttribute($value)
    {
        return $this->attributes['image_url'] = !empty($value) ? asset($value) : null;
    }
}
