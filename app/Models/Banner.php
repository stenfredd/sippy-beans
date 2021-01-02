<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'type',
        'product_id',
        'equipment_id',
        'title',
        'description',
        'image_url',
        'display_order',
        'url',
        'status'
    ];

    public function getImageUrlAttribute()
    {
        return !empty($this->attributes['image_url']) ? asset($this->attributes['image_url']) : null;
    }
}
