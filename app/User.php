<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function categories()
    {
        return $this->hasMany('App\Category');
    }
    public function tags()
    {
        return $this->hasMany('App\Tag');
    }
    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function relatedSites()
    {
        return $this->hasMany('App\RelatedSize');
    }
    public function approvePosts()
    {
        return $this->hasMany('App\Post', "admin_id", "id");
    }
}