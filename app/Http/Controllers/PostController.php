<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Posts;
use App\Models\Topics;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    public function __construct() {

    }

    public function create() {
        $redis = Redis::connection('default');
        $topics = unserialize($redis->get("topicsInfo"));
        if (count($topics)) {

        } else {
            $topics = Topics::getTopicsInfo();
            $redis->set("topicsInfo", serialize($topics));
        }
        return view('post.create')->with("topics", $topics);
    }

    public function store(Request $request) {
        return $request->all();
    }
}
