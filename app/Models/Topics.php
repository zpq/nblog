<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    public static function getTopicsInfo($limit = 50) {
    	return self::orderBy('post_number','DESC')->limit($limit)->get();
    }
}
