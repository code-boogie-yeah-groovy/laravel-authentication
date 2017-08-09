@extends('layouts.app')

@section('title')
  Account
@endsection

@section('content')
<div class="content">
  <div class="col-md-6 col-md-offset-3">
    <header>
      <div>
        <img src="{{ $user->avatar }}" alt="" class="big-avatar center-block img-circle img-responsive">
        <h1 class="text-center">{{ $user->name }}</h1>
      </div>
    </header>
  </div>
</div>
@include('includes.post-collection')
@include('includes.confirm-delete')
@endsection

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
