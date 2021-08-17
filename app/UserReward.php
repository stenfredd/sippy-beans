<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'reward_type',
        'reward_points'
    ];
}
