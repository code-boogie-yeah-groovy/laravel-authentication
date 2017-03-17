<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cloudinary;

class Post extends Model
{

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

    /**
    * Relationship: comments
    *
    * @return \Illuminate\Database\Eloquent\Relations\MorphTo
    */
   public function comments()
   {
       return $this->morphMany(Comment::class, 'commentable');
   }

}
