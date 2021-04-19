<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static select( string $string )
 */
class Favourite extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'equipment_id'
    ];

	public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function variant()
    {
        return $this->hasOne(Variant::class, 'id', 'variant_id');
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class, 'id', 'equipment_id');
    }
}
