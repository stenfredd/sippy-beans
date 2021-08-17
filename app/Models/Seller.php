<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'seller_name',
        'seller_info',
        'seller_image',
        'seller_address',
        'seller_phone',
        'seller_email',
        'status'
    ];
}
