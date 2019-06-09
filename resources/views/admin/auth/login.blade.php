@extends('admin.layouts.guestapp')

@section('title')
    {{ __('Admin Login Page') }}
@endsection

@section('css')
    
@endsection

@section('body')
  <section class="section text-auto">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 col-md-6 col-lg-6 col-xl-4 mr-auto ml-auto">
          <div class="login-brand">
            {{ config('app.name') }}
          </div>

          <div class="card card-primary">
            <div class="card-header"><h4>{{ __('Login') }}</h4></div>

            <div class="card-body">
              <form action="{{ route('admin.login') }}" method="post" class="needs-validation" novalidate="">
                @csrf
                <div class="form-group">
                  <label for="email">{{ __('Email') }}</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email') }}">

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>

                <div class="form-group">
                  <div class="d-block">
                    <label for="password" class="control-label">{{ __('Password') }}</label>
                    <div class="float-right">
                    </div>
                  </div>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
                
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" tabindex="3" name="remember" {{ old('remember') ? 'checked' : '' }} id="remember-me">
                    <label class="custom-control-label" for="remember-me">{{ __('Remember Me') }}</label>
                  </div>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-warning btn-lg btn-block" tabindex="4">
                    {{ __('Login') }}
                  </button>
                </div>
              </form>
              <a href="{{ route('admin.password.request') }}">{{ __('I forgot my password') }}</a>

            </div>
          </div>
          <div class="simple-footer">
            <strong>{{ __('Copyright') }} &copy; 2019-{{ Carbon\Carbon::now()->year }} <a href="/">{{ config('app.name') }}</a>.</strong> {{ __('All rights reserved') }}.
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('js')
  
@endsection