<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    protected $fillable = [
        'title',
        'type',
        'weight',
        'grams',
        'display_order',
        'status'
    ];
}
