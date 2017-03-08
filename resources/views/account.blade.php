@extends('layouts.app')

@section('title')
  Account
@endsection

@section('content')
  <section class="row new-post">
    <div class="col-md-6 col-md-offset-3">
      <header>
        <h3>Your Account</h3>
      </header>
      <form action="{{ route('account.save') }}" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input type="text" name="first_name" class="form-control" value="{{ $user->firstname }}" id="first_name">
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
  @if (Storage::disk('local')->has($user->firstname . '-' . $user->id . '.jpg'))
    <section class="row new-post">
      <div class="col-md-6 col-md-offset-3">
        <img src="{{ route('account.image', ['filename' => $user->firstname . '-' .$user->id . '.jpg']) }}" alt="" class="img-responsive">
      </div>
    </section>
  @endif
@endsection
