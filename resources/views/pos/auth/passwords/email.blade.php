@extends('pos.layouts.guestapp')

@section('title')
    {{ __('Worker Send Password Reset Mail') }}
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
            <div class="card-header"><h4>{{ __('Forgot Password') }}</h4></div>

            <div class="card-body">
                @if (session('status'))
                  <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                      <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                      </button>
                      {{ __(session('status')) }}
                    </div>
                  </div>
                @endif
              <form action="{{ route('pos.password.email') }}" method="post" class="needs-validation" novalidate="">
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
                  <button type="submit" class="btn btn-warning btn-lg btn-block">
                    {{ __('Forgot Password') }}
                  </button>
                </div>
              </form>
              <a href="{{ route('pos.login') }}">{{ __('Login') }}</a>

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