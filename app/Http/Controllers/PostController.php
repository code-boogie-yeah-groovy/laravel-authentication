<?php

namespace App\Http\Controllers;

use App\Post;
use App\Vote;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use JD\Cloudder\Facades\Cloudder;
use App\Comment;
use App\User;
use App\Post_tags;
use App\Tags;


class PostController extends Controller
{

  public function __construct()
    {
        $this->middleware('auth');
    }

  public function index()
  {
    $section = "Most Popular";
    $posts = Post::all();
    $posts = $posts->sortByDesc(function($post){
      return $post->points;
    });
    $comments = Comment::orderBy('id')->get();
    $upVotes = Vote::select('post_id')->where('user_id', Auth::user()->id)->where('vote', 1)->get();
    $upVoteArr = array_flatten($upVotes->toArray());
    $downVotes = Vote::select('post_id')->where('user_id', Auth::user()->id)->where('vote', 0)->get();
    $downVoteArr = array_flatten($downVotes->toArray());
    $post_tags = Post_tags::all();
    $tags = Tags::all();
    return view('home', ['posts' => $posts, 'comments' => $comments, 'section' => $section, 'upVotes' => $upVoteArr, 'downVotes' => $downVoteArr, 'post_tags' => $post_tags, 'tags' => $tags]);
  }

  public function indexTrending()
  {
    $section = "Today's Trending";
    $posts = Post::all();
    $posts = $posts->sortByDesc(function($post){
      return $post->wilson;
    });
    $comments = Comment::orderBy('id')->get();
    $upVotes = Vote::select('post_id')->where('user_id', Auth::user()->id)->where('vote', 1)->get();
    $upVoteArr = array_flatten($upVotes->toArray());
    $downVotes = Vote::select('post_id')->where('user_id', Auth::user()->id)->where('vote', 0)->get();
    $downVoteArr = array_flatten($downVotes->toArray());
    $post_tags = Post_tags::all();
    $tags = Tags::all();
    return view('home', ['posts' => $posts, 'comments' => $comments, 'section' => $section, 'upVotes' => $upVoteArr, 'downVotes' => $downVoteArr, 'post_tags' => $post_tags, 'tags' => $tags]);
  }

  public function indexNew()
  {
    $section = "Recent posts";
    $posts = Post::orderBy('id', 'desc')->get();
    $comments = Comment::orderBy('id')->get();
    $upVotes = Vote::select('post_id')->where('user_id', Auth::user()->id)->where('vote', 1)->get();
    $upVoteArr = array_flatten($upVotes->toArray());
    $downVotes = Vote::select('post_id')->where('user_id', Auth::user()->id)->where('vote', 0)->get();
    $downVoteArr = array_flatten($downVotes->toArray());
    $post_tags = Post_tags::all();
    $tags = Tags::all();
    return view('home', ['posts' => $posts, 'comments' => $comments, 'section' => $section, 'upVotes' => $upVoteArr, 'downVotes' => $downVoteArr, 'post_tags' => $post_tags, 'tags' => $tags]);
  }

  public function indexUser($user_id)
  {
    $section = "My posts";
    $user = User::find($user_id);
    $posts = Post::where('user_id', $user_id)->orderBy('id', 'desc')->get();
    $comments = Comment::orderBy('id')->get();
    $upVotes = Vote::select('post_id')->where('user_id', Auth::user()->id)->where('vote', 1)->get();
    $upVoteArr = array_flatten($upVotes->toArray());
    $downVotes = Vote::select('post_id')->where('user_id', Auth::user()->id)->where('vote', 0)->get();
    $downVoteArr = array_flatten($downVotes->toArray());
    $post_tags = Post_tags::all();
    $tags = Tags::all();
    return view('account', ['user' => $user, 'posts' => $posts, 'comments' => $comments, 'section' => $section, 'upVotes' => $upVoteArr, 'downVotes' => $downVoteArr, 'post_tags' => $post_tags, 'tags' => $tags]);
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
    if($_FILES['media']['name'] != "" && $_FILES['media']['size'] != 0) {
      $filename = 'post' . '-' . $date;
      $mime = $file->getMimeType();
      if ($mime == "video/x-flv" || $mime == "video/mp4" || $mime == "application/x-mpegURL" || $mime == "video/MP2T" || $mime == "video/3gpp" || $mime == "video/quicktime" || $mime == "video/x-msvideo" || $mime == "video/x-ms-wmv" || $mime == "video/webm") {
        Cloudder::uploadVideo($file, $filename);
        $post->type = 'video';
        $post->media_id = $filename;
      } elseif ($mime == "image/png" || $mime == "image/jpg" || $mime == "image/jpeg" || $mime == "image/gif") {
        Cloudder::upload($file, $filename);
        $post->type = 'image';
        $post->media_id = $filename;
      } else {
        $message = 'Invalid media.';
        return redirect()->route('new')->with(['message' => $message]);
      }
    }
    $message = 'There was an error.';
    if($request->user()->posts()->save($post)) {
      //$this->postAddTag($date);
      $message = 'Posted successfully.';
    }
    return redirect()->route('new')->with(['message' => $message, 'post_ts' => $date]);
  }


  public function postAddTag(Request $request)
  {
    $date = Carbon::createFromTimestamp($request['postTs'])->toDateTimeString();
    $post_tag = new Post_tags();
    $post = Post::where('created_at', $date)->first();
    $post_id = $post->id;
    $post_tag->post_id = $post_id;
    $post_tag->tag_id = $request['tagId'];
    $post_tag->save();
    return redirect()->back();
  }

  public function postDeletePost(Request $request)
  {
    $post = Post::where('id', $request['postId'])->first();
    if(Auth::user() != $post->user){
      return redirect()->back();
    }
    if ($post->media_id != null) {
      Cloudder::destroyImage($post->media_id, $options = array("resource_type" => $post->type ));
      Cloudder::destroy($post->media_id, $options = array("resource_type" => $post->type ));
      Cloudder::delete($post->media_id, $options = array("resource_type" => $post->type ));
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

  public function postWriteComment(Request $request)
  {
    $post_id = $request['postId'];
    $comment = $request['commentBody'];
    $user = Auth::user();
    $post = Post::find($post_id);
    $post->comments()->create([
      'user_id' => $user->id,
      'body' => $comment
    ]);
    return redirect()->route('home')->with(['message' => 'Comment Posted']);

  }

}
