<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'stripe_subscription_id',
        'subscription_id',
        'payment_id',
        'payment_type',
        'type',
        'amount',
        'status'
    ];
}
