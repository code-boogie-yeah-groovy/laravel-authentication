@extends('layouts.app')

@section('title')
  Account
@endsection

@section('content')
  <section class="row new-post">
    <div class="col-md-6 col-md-offset-3">
      <header>
        <h3>Your Account</h3>
        <div>
          <img src="{{ Auth::user()->avatar }}" alt="" class="img-responsive" style="inline: block; max-height: 100px; width: auto;">
        </div>
      </header>
      <form action="{{ route('account.save') }}" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control" value="{{ $user->name }}" id="name">
        </div>
        <div class="form-group">
          <label for="image">Image (only.jpg)</label>
          <input type="file" name="image" class="form-control" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Save Account</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
      </form>
    </div>
  </section>
@endsection
