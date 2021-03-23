<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    public function scopeSub($query, $sub = null)
    {
        if ($sub == '' && $sub == null) {
            return $query;
        } else if ($sub != null) {
            return $query->where("post_id", $sub);
        }
    }
    public function scopeSearch($query, $q = null)
    {
        if ($q != "" && $q != null) {
            return $query->where('comments', 'like', '%' . $q . '%');
        } else {
            return $query;
        }
    }
}