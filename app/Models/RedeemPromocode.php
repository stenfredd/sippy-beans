<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeemPromocode extends Model
{
    protected $fillable = [
    	'user_id',
    	'order_id',
    	'promocode',
    	'type',
    	'promocode_amount',
    	'redeem_amount',
    	'status'
    ];

    public function promocode_data() {
        return $this->belongsTo(Promocode::class, 'promocode', 'promocode');
    }
}
