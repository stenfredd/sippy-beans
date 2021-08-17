<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use stdClass;

/**
 * @method static whereStatus( int $int )
 */
class Product extends Model
{
    protected $fillable = [
        'product_name',
        'description',
        'varietal',
        'altitude',
        'sku',
        'price',
        'quantity',
        'flavor_note',
        'tags',
        'type_id',
        'origin_id',
        'brand_id',
        'brand_type_id',
        'characteristic_id',
        'best_for_id',
        'coffee_type_id',
        'level_id',
        'process_id',
        'seller_id',
        'tax_class_id',
        'category_id',
        'grind_type',
        'commission_fee',
        'commission_type',
        'display_order',
        'status'
    ];

    protected $hidden = [
        'seller',
        'origin',
        'brand',
        'type',
        'level',
        'coffee_type',
        'process',
        'characteristic',
        'best_for'
    ];

    public $appends = [
        'additional',
        'is_favourite'
    ];

    public function getAdditionalAttribute()
    {
        $additional = new stdClass();
        $additional->seller_name = $this->seller->seller_name ?? null;
        $additional->origin = $this->origin->origin_name ?? null;
        $additional->brand = $this->brand->name ?? null;
        $additional->type = $this->type->title ?? null;
        $additional->level = $this->level->level_title ?? null;
        $additional->coffee_type = $this->coffee_type->title ?? null;
        $additional->process = $this->process->title ?? null;
        $additional->characteristic = $this->characteristic->title ?? null;
        $additional->best_for = $this->best_for->title ?? null;
        return $this->attributes['additional'] = $additional;
    }

    public function getIsFavouriteAttribute()
    {
        return $this->is_favourite()->first() ? true : false;
    }

    public function is_favourite()
    {
        return $this->hasOne("App\Models\Favourite", "product_id", "id")->whereUserId(auth('api')->user()->id ?? 0);
    }

    public function images()
    {
        return $this->hasMany("App\Models\Image", "content_id", "id")->where("type", "product")->orderBy('display_order', 'asc');
    }

    public function variants()
    {
        return $this->hasMany("App\Models\Variant", "product_id", "id");
    }

    public function seller()
    {
        return $this->hasOne("App\Models\Seller", "id", "seller_id");
    }

    public function origin()
    {
        return $this->hasOne("App\Models\Origin", "id", "origin_id");
    }

    public function brand()
    {
        return $this->hasOne("App\Models\Brand", "id", "brand_id");
    }

    public function type()
    {
        return $this->hasOne("App\Models\Type", "id", "type_id");
    }

    public function level()
    {
        return $this->hasOne("App\Models\Level", "id", "level_id");
    }

    public function coffee_type()
    {
        return $this->hasOne("App\Models\CoffeeType", "id", "coffee_type_id");
    }

    public function process()
    {
        return $this->hasOne("App\Models\Process", "id", "process_id");
    }

    public function characteristic()
    {
        return $this->hasOne("App\Models\Characteristic", "id", "characteristic_id");
    }

    public function best_for()
    {
        return $this->hasOne("App\Models\BestFor", "id", "best_for_id");
    }

    public function weights()
    {
        // 1. Through table name
        // 2. relationship table name with current model
        // 3. relationship field with current model
        // 4. Through table primary id
        // 5. current model primary id
        // 6. relationship field with Through table
        return $this->hasManyThrough("App\Models\Weight", 'App\Models\Variant', 'product_id', 'id', 'id', 'weight_id')->orderBy('id', 'asc');
    }
}
