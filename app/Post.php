<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Builder;

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
    public function thumbnail()
    {
        return $this->belongsTo("App\Thumbnail");
    }
    public function response()
    {
        return $this->hasMany("App\Response");
    }
    public function scopeOwner($query, $user_id)
    {
        if ($user_id !== null) {
            return $query->where('user_id', $user_id);
        } else {
            return $query;
        }
    }
    // 
    public function scopeSearch($query, $variabelq = null)
    {
        if ($variabelq !== null && $variabelq !== '') {
            return $query->where('title', 'like', '%' . $variabelq . '%');
        } else {
            return $query;
        }
    }
    public function scopeDesc($query, $id = null)
    {
        if ($id == null && $id == "") {
            return $query->orderBy('id', 'asc');
        } else if ($id == "-id") {
            return $query->orderBy('id', 'desc');
        } else {
            return $query;
        }
    }
    public function scopeLimitPost($query, $limit = null)
    {
        if ($limit == null && $limit == "") {
            return $query;
        } else if ($limit != "") {
            return $query->limit($limit);
        }
    }
    public function scopeCategoryRole($query, $category)
    {
        if ($category == "" && $category == null) {
            return $query;
        } else if ($category != '') {
            $query->whereHas("category", function ($query) use ($category) {

                $query->where("name", $category);
            });
        }
    }
    public function scopeStatusPublish($query, $status = null)
    {
        if ($status == '' && $status == null) {
            return $query;
        } else if ($status == 'publish') {
            return $query->where('status', 'publish');
        } else {
            return $query;
        }
    }
}