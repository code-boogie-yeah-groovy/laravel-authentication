<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Actuallymab\LaravelComment\Commentable;

class Post extends Model
{
    use Commentable;

    protected $canBeRated = true;
    protected $mustBeApproved = false;

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function votes()
    {
      return $this->hasMany('App\Vote');
    }

}
