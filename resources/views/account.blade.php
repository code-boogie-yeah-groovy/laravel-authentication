@extends('layouts.app')

@section('title')
  Account
@endsection

@section('content')
    <div class="col-md-6 col-md-offset-3">
      <header>
        <div>
          <img src="{{ Auth::user()->avatar }}" alt="" class="big-avatar center-block img-circle img-responsive">
          <h1 class="text-center">{{ Auth::user()->name }}</h1>
        </div>
      </header>
@endsection
