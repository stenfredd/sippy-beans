<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'subscription_id',
        'stripe_subscription_id',
        'start_date',
        'end_date',
        'billing_date',
        'subscription_status',
        'cancelled_at',
        'status',
    ];
}
