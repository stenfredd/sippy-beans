<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static wherePage( string $string )
 */
class Page extends Model
{
    protected $fillable = [
        'page',
        'title',
        'description'
    ];
}
