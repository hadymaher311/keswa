@extends('user.layouts.app')

@section('title')
    {{ __('Login') }}
@endsection

@section('body')
    <!-- Main Container  -->
	<div class="main-container container">
        
        <div class="row">
            <div id="content" class="col-sm-12">
                <h2 class="title">{{ __('Login') }}</h2>
                <form action="{{ route('login') }}" method="post" enctype="multipart/form-data" class="form-horizontal account-register clearfix">
                    @csrf
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-email">{{ __('E-Mail Address') }}</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" id="input-email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-password">{{ __('Password') }}</label>
                        <div class="col-sm-10">
                            <input type="password" placeholder="{{ __('Password') }}" id="input-password" class="form-control" name="password" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check col-md-offset-2 col-md-10">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="buttons">
                            <input type="submit" value="{{ __('Login') }}" class="btn btn-primary">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request', app()->getLocale()) }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //Main Container -->
@endsection
