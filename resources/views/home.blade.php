@extends('layouts.app')

@section('content')
@include('includes.message-block')
<div class="content">
<section class="row new-post">
  <div class="col-md-6 col-md-offset-3">
    <header><h3>What do you want to say?</h3></header>
    <form class="" action="{{ route('post.create') }}" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Your post" style="resize:none;"></textarea>
      </div>
      <div class="form-group">
        <span class="btn btn-default btn-file">
          Add Photo/Video<input type="file" name="media" accept="image/*, video/mp4,video/x-m4v,video/webm, video/*" class="input_image form-control">
        </span>
        <button type="submit" class="btn btn-primary">Post</button>
      </div>
      <input type="hidden" value="{{ Session::token() }}" name="_token">
    </form>
  </div>
</section>
<section class="row posts">
  <div class="col-md-6 col-md-offset-3">
    <header><h3>What other people say?</h3></header>
    @foreach($posts as $post)
    <article class="post" data-postid="{{ $post->id }}" data-points="{{ $post->votes->where('vote',1)->count() - $post->votes->where('vote', 0)->count() }}">
      <div class="info">
        <img src="{{ $post->user->avatar }}" class="avatar-thumbnail img-responsive">
        <a href="#">{{ $post->user->name }} </a>posted this on {{ $post->created_at->format('M d, Y') }}
      </div>
      <div class="post-media">
        @if($post->type == 'image')
        <img src="{{ $post->url }}" class="post-image"/>
        @elseif($post->type == 'video')
        <video width="400" class="post-video" controls>
          <source src="{{ $post->url }}" type="video/mp4">
          <source src="{{ $post->url }}" type="video/webm">
          <source src="{{ $post->url }}" type="video/ogv">
          Your browser does not support HTML5 video.
        </video>
        @endif
      </div>
      <div class="post-text">
        <p>{{ app('profanityFilter')->filter($post->body) }}</p>
      </div>
      <span class="points badge badge-default">{{ $post->votes->where('vote',1)->count() - $post->votes->where('vote', 0)->count() }}</span>
      <div class="interactions">
        <a href="#" class="vote">Upvote</a>|
        <a href="#" class="vote">Downvote</a>|
        <a href="javascript:toggleDiv('comments_div{{ $post->id }}');" class="comment">
            Comments
            <span class="points badge badge-default">{{ $post->comments->where('commentable_id', $post->id)->count() }}</span>
        </a>|
        @if(Auth::user() == $post->user)
        <a href="#" class="edit-post">Edit</a>|
        <a href="#" class="delete-post" data-toggle="modal" data-target="#deleteModal">Delete</a>
        @endif
        @if(Auth::user() != $post->user)
        <a href="#" class="report">Report this post</a>
        @endif
      </div>
      <div class="comments_div" id="comments_div{{ $post->id }}">
        @foreach($comments as $comment )
          @if($post->id == $comment->commentable_id)
            @include('includes.comment-block')
          @endif
        @endforeach
        <div class="write-comment">
          <input type="text" name="comment"  id="comment_body{{ $post->id }}">
          <a href="#" class="post-comment">Post Comment</a>
          <input type="hidden" value="{{ Session::token() }}" name="_token">
        </div>
      </div>
    </article>
    @endforeach
  </div>
</section>
<!--Edit post Modal-->
@include('edit-post')
@include('includes.confirm-delete')
</div>

<script>
  var token = '{{ Session::token() }}';
  var urlEdit = '{{ route('edit') }}';
  var urlDelete = '{{ route('post.delete') }}';
  var urlVote = '{{ route('vote') }}';
  var urlComment = '{{ route('comment') }}';


  function toggleDiv(divId) {
    $("#"+divId).toggle();
  }
</script>
@endsection
