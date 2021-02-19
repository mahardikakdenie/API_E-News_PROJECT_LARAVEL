<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function scopeSearch($query, $variabelq = null)
    {
        if ($variabelq !== null && $variabelq !== '') {
            return $query->where('name', 'like', '%' . $variabelq . '%');
        } else {
            return $query;
        }
    }
}