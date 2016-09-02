<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Topics extends Model
{
    public static function getTopicsInfo($limit = 50) {
    	return self::where('post_number', '>', '0')->orderBy('post_number','DESC')->limit($limit)->get();
    }

    public static function getTopicsLists($limit = 20) {
        $redis = Redis::connection('default');
        $topicsLists = unserialize($redis->get('nblog_topicsInfo'));
        if ($topicsLists && count($topicsLists)) {

        } else {
            $topicsLists= [];
            $topicsLists = self::getTopicsInfo($limit);
            if (count($topicsLists)) {
                $redis->set('nblog_topicsInfo', serialize($topicsLists));
            }
        }
        return $topicsLists;
    }


}
