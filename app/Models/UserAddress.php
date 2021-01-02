<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'country_id',
        'city_id',
        'title',
        'address_line_1',
        'address_line_2',
        'latitude',
        'longitude',
        'is_default'
    ];

    public function city()
    {
        return $this->hasOne("App\Models\City", "id", "city_id");
    }

    public function country()
    {
        return $this->hasOne("App\Models\Country", "id", "country_id");
    }
}
