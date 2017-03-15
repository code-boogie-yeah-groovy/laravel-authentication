@extends('layouts.app')

@section('title')
  Account
@endsection

@section('content')
    <div class="col-md-6 col-md-offset-3">
      <header>
        <h3>Edit Your Account</h3>
      </header>
      <form action="{{ route('account.save') }}" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <div>
            <img src="{{ $user->avatar }}" alt="" class="image_preview big-avatar center-block img-responsive" id="avatar_preview">
          </div>
        </div>
        <div class="form-group">
          <label for="image">Change Avatar:</label>
          <span class="btn btn-default btn-file">
            Browse<input type="file" name="image" accept="image/*" class="input_image form-control" id="input_avatar">
          </span>
        </div>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control" value="{{ $user->name }}" id="name">
        </div>
        <button type="submit" class="btn btn-primary">Save Account</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
      </form>
    </div>
@endsection
