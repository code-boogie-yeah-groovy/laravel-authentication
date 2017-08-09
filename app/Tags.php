<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    //
    public function postTags()
    {
      return $this->hasMany('App\Post_tags');
    }
}
