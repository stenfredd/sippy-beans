<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'product_id',
        'weight_id',
        'grind_ids',
        'title',
        'sku',
        'price',
        'quantity',
        'is_default',
        'reward_point',
        'status'
    ];

    public function images()
    {
        return $this->hasOne("App\Models\Image", "content_id", "id")->where("type", "variant")->orderBy('display_order', 'asc');
    }

    public function weight()
    {
        return $this->hasOne("App\Models\Weight", "id", "weight_id");
    }

    public function product()
    {
        return $this->belongsTo("App\Models\Product", "product_id", "id");
    }
}
