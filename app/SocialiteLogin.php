<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialiteLogin extends Model
{

  protected $fillable = [
    'user_id', 'social_id', 'provider'
  ];

  public function user() {
    return $this->belongsTo('App\User');
  }
}
