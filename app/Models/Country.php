<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'country_name',
        'flag_image',
        'status'
    ];

    public function cities()
    {
        return $this->hasMany("App\Models\City", "country_id", "id");
    }
}
