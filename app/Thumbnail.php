<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    public function post()
    {
        return $this->hasOne("App\Post");
    }
    public function getUrlAttribute()
    {
        if ($this->attributes['url'] != null) {
            return  env('IMAGE_URL', 'http://127.0.0.1:8000/storage/') . $this->attributes['url'];
        } else {
            return $this->attributes['url'];
        }
    }
}