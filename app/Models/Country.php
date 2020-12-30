<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'country_name',
        'status'
    ];

    public function cities() {
        $this->hasMany("App\Models\City", "country_id", "id");
    }
}
