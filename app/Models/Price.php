<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'title',
        'min_price',
        'max_price',
    	'status'
    ];
}
