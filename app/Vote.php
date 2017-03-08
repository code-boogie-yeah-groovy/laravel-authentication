<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function post()
    {
      return $this->belongsTo('App\Post');
    }

    public function points ()
    {
      return $post->votes->where('vote',1)->count() - $post->votes->where('vote', 0)->count();
    }
}
