@extends('admin.layouts.guestapp')

@section('title')
    {{ __('Admin Login Page') }}
@endsection

@section('css')
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/admin_styles/css/square/orange.css') }}">
@endsection

@section('body')
<div class="login-box">
    <div class="login-logo">
      <a href="{{ url('/') }}"><b>{{ config('app.name') }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">{{ __('Signin to start your session') }}</p>
  
      <form action="{{ route('admin.login') }}" method="post">
        @csrf
        <div class="form-group has-feedback">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email') }}">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group has-feedback">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row text-center">
          <div class="col-sm-6">
            <div class="checkbox icheck">
              <label>
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <button type="submit" class="btn bg-orange btn-block btn-flat">{{ __('Login') }}</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
  
      <a href="{{ route('admin.password.request') }}">{{ __('I forgot my password') }}</a>
  
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->
  
@endsection

@section('js')
    <!-- iCheck -->
    <script src="{{ asset('/admin_styles/js/icheck.min.js') }}"></script>
    <script>
    $(function () {
        $('input').iCheck({
        checkboxClass: 'icheckbox_square-orange',
        radioClass: 'iradio_square-orange',
        increaseArea: '20%' // optional
        });
    });
    </script>
@endsection