<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereStatus( int $int )
 * @method static with( string[] $array )
 */
class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'title',
        'short_description',
        'description',
        'sku',
        'price',
        'reward_point',
        'quantity',
        'weight',
        'brand_id',
        'type_id',
        'roster_type_id',
        'seller_id',
        'tax_class_id',
        'category_id',
        'commission_fee',
        'commission_type',
        'tags',
        'display_order',
        'status'
    ];

    protected $hidden = [
        'seller',
        'brand',
        'type'
    ];

    public $appends = [
        'additional'
    ];

    public function getAdditionalAttribute()
    {
        $additional = new \stdClass();
        $additional->seller_name = $this->seller->seller_name ?? null;
        $additional->brand = $this->brand->name ?? null;
        $additional->type = $this->type->title ?? null;
        return $this->attributes['additional'] = $additional;
    }

    public function brand()
    {
        return $this->hasOne("App\Models\Brand", "id", "brand_id");
    }

    public function type()
    {
        return $this->hasOne("App\Models\Type", "id", "type_id");
    }

    public function seller()
    {
        return $this->hasOne("App\Models\Seller", "id", "seller_id");
    }

    public function taxClass()
    {
        return $this->hasOne("App\Models\TaxClass", "id", "tax_class_id");
    }

    public function images()
    {
        return $this->hasMany("App\Models\Image", "content_id", "id")->where("type", "equipment")->orderBy('display_order', 'asc');
    }
}
