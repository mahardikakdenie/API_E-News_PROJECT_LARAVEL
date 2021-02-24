<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $defaultPagination = ['number' => 1];
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function admin()
    {
        return $this->belongsTo('App\User', 'admin_id', "id");
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag', "post_tag", "post_id", 'tag_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function scopeOwner($query, $user_id)
    {
        if ($user_id !== null) {
            return $query->where('user_id', $user_id);
        } else {
            return $query;
        }
    }


    public function scopeSearch($query, $variabelq = null)
    {
        if ($variabelq !== null && $variabelq !== '') {
            return $query->where('title', 'like', '%' . $variabelq . '%');
        } else {
            return $query;
        }
    }
}