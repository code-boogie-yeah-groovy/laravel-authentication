@extends('layouts.app')

@section('content')
@include('includes.message-block')
<div class="content">
<section class="row new-post">
  <div class="col-md-6 col-md-offset-3">
    <header><h3>What do you want to say?</h3></header>
    <form class="" action="{{ route('post.create') }}" method="post">
      <div class="form-group">
        <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Your post"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Post</button>
      <input type="hidden" value="{{ Session::token() }}" name="_token">
    </form>
  </div>
</section>
<section class="row posts">
  <div class="col-md-6 col-md-offset-3">
    <header><h3>What other people say?</h3></header>
    @foreach($posts as $post)
    <article class="post" data-postid="{{ $post->id }}">
      <div class="info">
        <img src="{{ $post->user->avatar }}" class="avatar-thumbnail img-responsive">
        {{ $post->user->name }} posted this on {{ $post->created_at }}
      </div>
      <div class="post-text">
      <p>{{ $post->body }}</p>
      </div>
        <span id="points">{{ $post->votes->where('vote',1)->count() - $post->votes->where('vote', 0)->count() }}</span>
      <div class="interactions">
        <a href="#" class="vote">Upvote</a>|
        <a href="#" class="vote">Downvote</a>
        @if(Auth::user() == $post->user)
        |
        <a href="#" class="edit-post">Edit</a>|
        <a href="{{ route('post.delete', ['post_id' => $post->id]) }}">Delete</a>
        @endif
      </div>
    </article>
    @endforeach
  </div>
</section>
<!--Edit post Modal-->
@include('edit-post')
</div>

<script>
  var token = '{{ Session::token() }}';
  var urlEdit = '{{ route('edit') }}';
  var urlVote = '{{ route('vote') }}';
</script>
@endsection
