<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchMakers extends Model
{
    protected $fillable = [
        'image_url',
        'question',
        'type',
        'min_select',
        'max_select',
        'status'
    ];

    public function getImageUrlAttribute($value) {
        return $this->attributes['image_url'] = !empty($value) ? asset($value) : null;
    }
}
