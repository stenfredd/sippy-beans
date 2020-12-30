<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $fillable = [
        'origin_name',
        'display_order',
        'status'
    ];
}
