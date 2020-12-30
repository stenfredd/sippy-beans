<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'brand_image',
        'name',
        'short_description',
        'description',
        'display_order',
        'status'
    ];

    public function getBrandImageAttribute($value)
    {
        if(!empty($value) && file_exists(public_path('uploads/brands/'.$value)))
        {
            $value = asset($value);
        }
        else
        {
            $value = asset('images/user-default.png');
        }
        return $value;
    }
}
