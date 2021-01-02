<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'type',
        'content_id',
        'image_path',
        'is_featured',
        'display_order',
        'status'
    ];

    protected $appends = [
        'image_path'
    ];

    public function getImagePathAttribute()
    {
        return isset($this->attributes['image_path']) ? asset($this->attributes['image_path']) : null;
    }
}
