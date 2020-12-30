<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'type_icon',
        'title',
        'description',
        'display_order',
        'status'
    ];

    public function getTypeIconAttribute($value) {
        return $this->attributes['type_icon'] = !empty($value) ? asset($value) : null;
    }
}
