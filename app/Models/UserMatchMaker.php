<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereUserId( $id )
 */
class UserMatchMaker extends Model
{
    protected $fillable = [
        'user_id',
        'match_maker_id',
        'values'
    ];
}
