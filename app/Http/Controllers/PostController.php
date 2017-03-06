<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

  public function index()
  {
    $posts = Post::all();
    return view('home', ['posts' => $posts]);
  }

  public function postCreatePost( Request $request )
  {
    //Validation
    $this->validate($request, [
      'body' => 'required|max:1000'
    ]);

    //Save to database
    $post = new Post();
    $post->body = $request['body'];
    $message = 'There was an error.';
    if($request->user()->posts()->save($post)) {
      $message = 'Posted successfully.';
    }
    return redirect()->route('home')->with(['message' => $message]);
  }

  public function getPostDelete($post_id) {

  }

}
