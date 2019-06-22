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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('password.email') }}" method="post" class="form-horizontal account-register clearfix">
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
                    <div class="buttons">
                            <input type="submit" value="{{ __('Send Password Reset Link') }}" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //Main Container -->
@endsection
