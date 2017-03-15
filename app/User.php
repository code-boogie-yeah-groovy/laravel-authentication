<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Actuallymab\LaravelComment\CanComment;

class User extends Authenticatable
{
    use Notifiable;
    use CanComment;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fullname() {
      return "$this->firstname $this->lastname";
    }

    public function posts() {
      return $this->hasMany('App\Post');
    }

    public function votes()
    {
      return $this->hasMany('App\Vote');
    }
}
