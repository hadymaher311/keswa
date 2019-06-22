@extends('user.layouts.app')

@section('title')
    {{ __('Reset Password') }}
@endsection

@section('body')
    <!-- Main Container  -->
	<div class="main-container container">
        
        <div class="row">
            <div id="content" class="col-sm-12">
                <h2 class="title">{{ __('Reset Password') }}</h2>
                <p>{{ __('If you already have an account with us, please login at the') }} <a href="{{ route('login') }}">{{ __('login page') }}</a>.</p>
                <form action="{{ route('password.update') }}" method="post" enctype="multipart/form-data" class="form-horizontal account-register clearfix">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                
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
                            <input type="password" placeholder="{{ __('Password') }}" id="input-password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-confirm">{{ __('Confirm Password') }}</label>
                        <div class="col-sm-10">
                            <input type="password" name="password_confirmation" value="" placeholder="{{ __('Confirm Password') }}" id="input-confirm" class="form-control">
                        </div>
                    </div>
                    <div class="buttons">
                            <input type="submit" value="{{ __('Reset Password') }}" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //Main Container -->
@endsection
