<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoffeeFlavor extends Model
{
    protected $fillable = [
        'flavor_name',
        'display_order',
        'status'
    ];
}
