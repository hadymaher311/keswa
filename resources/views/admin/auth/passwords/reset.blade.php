@extends('admin.layouts.guestapp')

@section('title')
    {{ __('Admin Reset Password') }}
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
            <div class="card-header"><h4>{{ __('Reset Password') }}</h4></div>

            <div class="card-body">
              <form action="{{ route('admin.password.request') }}" method="post" class="needs-validation" novalidate="">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
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
                  <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                  <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-warning btn-lg btn-block">
                    {{ __('Reset Password') }}
                  </button>
                </div>
              </form>
              <a href="{{ route('admin.login') }}">{{ __('Login') }}</a>

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