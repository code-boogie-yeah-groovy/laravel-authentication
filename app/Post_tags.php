<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post_tags extends Model
{

    protected $table = 'post_tags';
    protected $primaryKey = 'id';

    public function post()
    {
      return $this->belongsTo('App\Post', 'post_id');
    }

    public function tag()
    {
      return $this->belongsTo('App\Tags');
    }
}
