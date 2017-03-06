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
    <header><h3>What othere people say?</h3></header>
    @foreach($posts as $post)
    <article class="post">
      <p>{{ $post->body }}</p>
      <div class="info">
        Posted by {{ $post->user->fullname() }} on {{ $post->created_at }}
      </div>
      <div class="interactions">
        <a href="#">Upvote</a>|
        <a href="#">Downvote</a>|
        <a href="#">Edit</a>|
        <a href="#">Delete</a>
      </div>
    </article>
    @endforeach
  </div>
</section>
</div>
@endsection
