<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function scopePostId($query, $post_id)
    {
        if ($post_id != '' || $post_id != null) {
            return $query->where("post_id", $post_id);
        } else {
            return $query;
        }
    }
}