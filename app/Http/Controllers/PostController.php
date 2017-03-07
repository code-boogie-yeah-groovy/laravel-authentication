<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{

  public function index()
  {
    $posts = Post::orderBy('created_at', 'desc')->get();
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

  public function getPostDelete($post_id)
  {
    $post = Post::where('id', $post_id)->first();
    if(Auth::user() != $post->user){
      return redirect()->back();
    }
    $post->delete();
    return redirect()->route('home')->with(['message' => 'Successfully deleted']);
  }

  public function postEditPost(Request $request)
  {
    $this->validate($request, [
      'body' => 'required'
    ]);
    $post = Post::find($request['postId']);
    if(Auth::user() != $post->user){
      return redirect()->back();
    }
    $post->body = $request['body'];
    $post->update();
    return response()->json(['new_body' => $post->body], 200);
  }

}
