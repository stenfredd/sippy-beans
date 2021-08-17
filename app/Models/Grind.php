<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereIn( string $string, array $product_grind_ids )
 */
class Grind extends Model
{
    protected $fillable = [
    	'title',
    	'status'
    ];
}
