<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $fillable = [
        'title',
        'promocode',
        'start_date',
        'end_date',
        'used_limit',
        'promocode_type',
        'discount_type',
        'discount_amount',
        'one_time_user',
        'status',
    ];
}
