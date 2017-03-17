<?php
namespace App;
class Cloudinary {
   public static function getURL($media_id, $type) {
     return "https://res.cloudinary.com/".env('CLOUDINARY_CLOUD_NAME')."/$type/upload/$media_id";
   }
}
