<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'order_type', // subscription, manual -> normal

        'cart_total',
        'delivery_fee',

        'discount_type',
        'discount_amount',
        'promocode',
        'promocode_amount',

        'subtotal',
        'tax_charges',

        'total_amount',
        'payment_received',

        'payment_type',
        'card_type',
        'card_number',

        'reward_points',

        'customer_note',
        'internal_note',
        'payment_status',
        'status'
    ];

    protected $appends = [
        'status_text',
        'payment_type'
    ];

    public function getPaymentTypeAttribute() {
        $value = $this->attributes['payment_type'] ?? '';
        $payment_type = '';
        if($value == 1) {
            $payment_type = 'Cash on Delivery';
        }
        else if($value == 2) {
            $payment_type = 'Card';
        }
        return $payment_type;
    }

    public function getStatusTextAttribute() {
        $value = $this->attributes['status'] ?? 0;
        $status_text = 'New';
        if($value === 1) {
            $status_text = 'In Progress';
        }
        else if($value === 2) {
            $status_text = 'Shipped';
        }
        else if($value === 3) {
            $status_text = 'Completed';
        }
        else if($value === 4) {
            $status_text = 'Cancelled';
        }
        return $this->attributes['status_text'] = $status_text;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class, 'id', 'address_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'order_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(ActivityLog::class, 'order_id', 'id');
    }
}
