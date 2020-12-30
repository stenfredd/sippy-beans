<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_title',
        'short_description',
        'description',
        'display_order',
        'status'
    ];
}
