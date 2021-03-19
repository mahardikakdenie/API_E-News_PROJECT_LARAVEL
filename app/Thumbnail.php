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
            return  env('IMAGE_URL', 'https://mynews22.herokuapp.com/storage/') . $this->attributes['url'];
        } else {
            return $this->attributes['url'];
        }
    }
}