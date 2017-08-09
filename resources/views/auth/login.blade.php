@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Login</div>
        <div class="panel-body">
          <div class="col-lg-8">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">E-Mail Address</label>

              <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Login
                </button>

                <a class="btn btn-link" href="{{ route('password.request') }}">
                  Forgot Your Password?
                </a>
              </div>
            </div>
          </form>
          </div>
          <div class="col-lg-4">
            <a href="/auth/facebook" class="btn btn-block btn-social btn-facebook">
              <span class="fa fa-facebook"></span> Sign in with Facebook
            </a>
            <a href="/auth/google" class="btn btn-block btn-social btn-google">
              <span class="fa fa-google"></span> Sign in with Google
            </a>
            <a href="/auth/twitter" class="btn btn-block btn-social btn-twitter" style="display:none;">
              <span class="fa fa-twitter"></span> Sign in with Twitter
            </a>
            <a href="/auth/instagram" class="btn btn-block btn-social btn-instagram" style="display:none;">
              <span class="fa fa-instagram"></span> Sign in with Instagram
            </a>

            @if(session('emailExists'))
              <div class="alert alert-danger" style="margin-top: 24px">
                <strong>Error! </strong>Your email {{ session('emailExists') }} already exists!
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
