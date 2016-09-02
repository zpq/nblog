<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    const limit = 10;

    protected $fillable = ['title', 'author_id', 'topic_id', 'content'];

    public function Topic() {
        return $this->belongsTo("App\Models\Topics");
    }

    public function author() {
        return $this->belongsTo("App\Models\User");
    }

    public static function getPosts($limit = self::limit) {
        return self::orderBy("updated_at", "DESC")->paginate($limit);
    }

    public static function getPostsByTopic($topic_id, $limit = self::limit) {
        return self::where('topic_id', $topic_id)->orderBy("updated_at", "DESC")->paginate($limit);
    }

    public static function getPostsByAuthor($author_id, $limit = self::limit) {
        return self::where('author_id', $author_id)->orderBy("updated_at", "DESC")->paginate($limit);
    }
    
}
