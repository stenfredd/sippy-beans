<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPromocode extends Model
{
    protected $fillable = [
        'user_id',
        'promocode_id'
    ];
}
