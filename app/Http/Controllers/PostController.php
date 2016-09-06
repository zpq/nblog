<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Posts;
use App\Models\Topics;
use Illuminate\Support\Facades\Redis;
use EndaEditor;

class PostController extends Controller
{
    public function __construct() {

    }

    public function show($id) {
        if ($id) {
            $redis = Redis::connection('default');
            $post = $redis->get("nblog_post_$id");
            if ($post) {
                $post = unserialize($post);
            } else {
                $post = Posts::findOrFail($id);
                $redis->set("nblog_post_" . $id, serialize($post));
            }
        } else {
            abort(404);
        }
        $post->content = preg_replace('/<script.*script>/i', '', $post->content);
        $post->content = EndaEditor::MarkDecode($post->content);
        return view('post.show')->with(["post" => $post, 'updateSign' => true]);
    }

    public function lists() {

    }

    public function listsByTopicId($id) {
        $posts = Posts::getPostsByTopic($id);
        return view('home')->with('posts', $posts);
    }

    public function create() {
        $topics = Topics::getTopicsLists(50);
        return view('post.create')->with("topics", $topics);
    }

    public function store(Request $request) {
        $this->validate($request, [
				'title' => 'required|unique:posts|max:128',
				'content' => 'required',
				'topic' => 'required|max:32'
		]);
        $post['title'] = $request->input('title');
        $post['content'] = $request->input('content');
        $topic = Topics::where('name', $request->input('topic'))->first();
        if ($topic) {
            $topic->post_number += 1;
            $topic->update();
        } else {
            $topic = new Topics;
            $topic->name = $request->input('topic');
            $topic->post_number = 1;
            $topic->save();
        }
        $topics = Topics::getTopicsInfo(); // refresh topics list cache
        if (count($topics)) {
            $redis = Redis::connection('default');
            $redis->set("nblog_topicsInfo", serialize($topics));
        }
        $post['topic_id'] = $topic->id;
        $post['author_id'] = \Auth::user()->id;
        $postResult = Posts::create($post);
        return redirect('post/' . $postResult->id);
    }

    public function update($id) {
        $postExists = Posts::findOrFail($id);
        if (\Auth::user()->can('update-post', $postExists)) {
            $topics = Topics::getTopicsLists(50);
            return view('post.update')->with(['post' => $postExists, "topics"=> $topics]);
        } else {
            return redirect('/');
        }
    }

    public function storeWithUpdate(Request $request) {
        $this->validate($request, [
                'id' => 'required',
                'title' => 'required|max:128',
				'content' => 'required',
				'topic' => 'required|max:32'
        ]);
        $update = $request->except(['_token']);
        if ($update['id']) { // update ? cache
            $postExists = Posts::findOrFail($update['id']);
            if (!$request->user()->can('update-post', $postExists)) {
                abort(401);
            }
            $postExists->title = $update['title'];
            $postExists->content = $update['content'];
            $postExists->updated_at = date("Y-m-d H:i:s");
            $topicExists = Topics::where('name', $update['topic'])->first();
            if ($topicExists) {
                if ($postExists->topic_id != $topicExists->id) {
                    $topicChange = true;
                    $preTopic = Topics::find($postExists->topic_id);
                    if ($preTopic && $preTopic->post_number > 0) {
                        $preTopic->post_number -= 1;
                        $preTopic->update();
                    }
                    $topicExists->post_number += 1;
                    $topicExists->update();
                }
            } else {
                $topicExists = new Topics;
                $topicExists->name = $update['topic'];
                $topicExists->post_number = 1;
                $topicExists->save();
            }
            $postExists->topic_id = $topicExists->id;
            $postExists->update();

            //update cache
            $redis = Redis::connection('default');
            $redis->set("nblog_post_" . $postExists->id, serialize($postExists));
            if (isset($topicChange) && $topicChange) { //改了主题就才需要更新主题缓存
                $redis->set('nblog_topicsInfo', '');
            }
            return redirect("post/" . $postExists->id);
        } else {
            abort(404);
        }
    }

    public function uploadPostImage() {
        $data = EndaEditor::uploadImgFile('uploadPostImages');
		return json_encode($data);
    }

}
