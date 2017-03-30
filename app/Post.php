<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Cloudinary;

class Post extends Model
{

    protected $appends = ['url', 'points', 'wilson'];
    protected $canBeRated = true;
    protected $mustBeApproved = false;

    public function getUrlAttribute() {
      return $this->attributes['url'] = Cloudinary::getURL($this->media_id, $this->type);
    }

    public function getPointsAttribute() {
      $up = DB::table('votes')->where('post_id', $this->id)->where('vote', 1)->count();
      $down = DB::table('votes')->where('post_id', $this->id)->where('vote', 0)->count();
      return $this->attributes['points'] = $up-$down;
    }

    public function getWilsonAttribute() {
      $up = DB::table('votes')->where('post_id', $this->id)->where('vote', 1)->count();
      $down = DB::table('votes')->where('post_id', $this->id)->where('vote', 0)->count();
      $z = 1.281551565545;
      $n = $up+$down;
      if($n == 0) {
        return $this->attributes['wilson'] = 0;
      } else {
        $p = $up / $n;
        $left = $p + 1/(2*$n)*$z*$z;
        $right = $z*sqrt($p*(1-$p)/$n + $z*$z/(4*$n*$n));
        $under = 1+1/$n*$z*$z;
        return $this->attributes['wilson'] = ($left-$right)/$under;
      }
    }

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
