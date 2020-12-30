<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestFor extends Model
{
    protected $fillable = [
        'title',
        'display_order',
        'status'
    ];
}
