@extends('layouts.app')

@section('content')
@include('includes.message-block')
<div class="content">
<section class="row new-post">
  <div class="col-md-6 col-md-offset-3">
    <header class="text-center">
      <h3><a class="btn btn-info btn-lg btn-block" href="javascript:toggleDiv('post_div')">Write a post</a></h3>
    </header>
    <div id="post_div">
      <form class="" action="{{ route('post.create') }}" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <textarea class="form-control" name="body" id="new-post" rows="5" placeholder="Your post" style="resize:none;"></textarea>
        </div>
        <div class="form-group pull-right">
          <span class="btn btn-default btn-file">
            Add Photo/Video<input type="file" name="media" accept="image/*, video/mp4,video/x-m4v,video/webm, video/*" class="input_image form-control">
          </span>
          <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#addTagModal">Post</button>
        </div>
        <input type="hidden" value="{{ Session::token() }}" name="_token">
      </form>
    </div>
  </div>
</section>
@include('includes.post-collection')
<!--Edit post Modal-->
@include('edit-post')
@include('includes.confirm-delete')
@include('includes.add-tag')
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
