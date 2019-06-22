@extends('user.layouts.app')

@section('title')
    {{ __('Verify Your Email Address') }}
@endsection

@section('body')
    <!-- Main Container  -->
	<div class="main-container container">
        
        <div class="row">
            <div class="col-md-8 col-md-offset-2" style="margin-top: 5rem;">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ __('Verify Your Email Address') }}</div>
    
                    <div class="panel-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
    
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //Main Container -->
@endsection
