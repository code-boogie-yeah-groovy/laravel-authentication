<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Actuallymab\LaravelComment\Commentable;
use App\Cloudinary;

class Post extends Model
{
    use Commentable;

    protected $appends = ['url'];
    public function getUrlAttribute() {
      return $this->attributes['url'] = Cloudinary::getURL($this->media_id, $this->type);
    }

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

    public function comments()
    {
        return $this->morphMany('Comment', 'post');
    }

}
