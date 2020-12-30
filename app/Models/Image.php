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

    /* protected $hidden = [
        'type',
        'content_id',
        'created_at',
        'updated_at'
    ]; */

    protected $appends = [
        'image_path'
    ];

    public function getImagePathAttribute() {
        return isset($this->attributes['image_path']) ? asset($this->attributes['image_path']) : null;
    }
}
