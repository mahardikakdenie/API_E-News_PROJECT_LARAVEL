<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function users()
    {
        return $this->belongsTo('App\User');
    }
    public function post()
    {
        return $this->hasMany('App\Category');
    }
}