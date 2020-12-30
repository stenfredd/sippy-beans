<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'country_id',
        'name',
        'display_order',
        'delivery_fee',
        'delivery_time',
        'status'
    ];

    public function country() {
        return $this->hasOne("App\Models\Country", "id", "country_id");
    }
}
