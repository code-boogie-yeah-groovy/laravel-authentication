<?php

namespace App\Http\Controllers;

use App\Post;
use App\Vote;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use JD\Cloudder\Facades\Cloudder;


class PostController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }

  public function index()
  {
    $posts = Post::orderBy('created_at', 'desc')->get();
    return view('home', ['posts' => $posts]);
  }

  public function postCreatePost( Request $request )
  {
    //Validation
    $this->validate($request, [
      'body' => 'required|max:1000',
      'image' => 'sometimes|mimes:jpeg,bmp,png|max:528385',
      'video' => 'sometimes|mimes:mp4,mov,ogg,qt | max:20000'
    ]);

    //Save to database
    $post = new Post();
    $post->body = $request['body'];
    $date = Carbon::now()->timestamp;
    $file = $request->file('media');
    if($_FILES['media']['name'] != "") {
      $filename = 'post' . '-' . $date .  '.jpg';
      Cloudder::upload($file, $filename);
      $post->image = Cloudder::show($filename);
    }
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

  public function postVotePost(Request $request)
  {
    $post_id = $request['postId'];
    $is_vote = $request['isVote'] === 'true';
    $post_points = $request['points'];
    $update = false;
    $post = Post::find($post_id);
    if (!$post) {
        return null;
    }
    $user = Auth::user();
    $vote = $user->votes()->where('post_id', $post_id)->first();
    if ($vote) {
        $already_vote = $vote->vote;
        $update = true;
        if ($already_vote == $is_vote) {
            $vote->delete();
            return null;
        }
    } else {
        $vote = new Vote();
    }
    $vote->vote = $is_vote;
    $vote->user_id = $user->id;
    $vote->post_id = $post->id;
    if ($update) {
        $vote->update();
    } else {
        $vote->save();
    }
    return null;
  }

}
