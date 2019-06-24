@extends('user.layouts.app')

@section('title')
    {{ auth()->user()->name }} - {{ __('Personal info') }} - {{ config('app.name') }}
@endsection

@section('css')
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">

    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-9">
            <div class="row">
                <div class="col-sm-12">
                    <form action="{{ route('user.info.update') }}" method="post" class="form-horizontal account-register clearfix">
                        @csrf
                        @method('PUT')
                        <fieldset id="address">
                            <legend>{{ __('Edit Personal Details') }}</legend>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-firstname">{{ __('First Name') }}</label>
                                <div class="col-sm-10">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ auth()->user()->first_name }}" required autocomplete="first_name" placeholder="{{ __('First Name') }}" autofocus>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-lastname">{{ __('Last Name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ auth()->user()->last_name }}" required autocomplete="last_name" placeholder="{{ __('Last Name') }}" id="input-lastname">
    
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-email">{{ __('E-Mail Address') }}</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" id="input-email">
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-telephone">{{ __('Phone Number') }}</label>
                                <div class="col-sm-10">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ auth()->user()->personalInfo->phone }}" required autocomplete="phone" placeholder="{{ __('Phone Number') }}" id="input-telephone" class="form-control">
    
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-gender">{{ __('Gender') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ auth()->user()->personalInfo->gender }}" required id="input-gender" class="form-control">
                                        <option value=""> --- {{ __('Please Select') }} --- </option>
                                        <option {{ (auth()->user()->personalInfo->gender == 'male') ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
                                        <option {{ (auth()->user()->personalInfo->gender == 'female') ? 'selected' : '' }} value="female">{{ __('Female') }}</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>
                        <div class="buttons">
                            <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
                        </div>
                    </form>
                </div>

                <div class="col-sm-12">
                    <form action="{{ route('user.password.update') }}" method="post" class="form-horizontal account-register clearfix">
                        @csrf
                        @method('PUT')
                        <fieldset id="address">
                            <legend>{{ __('Edit password') }}</legend>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-old-password">{{ __('Old Password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" placeholder="{{ __('Old Password') }}" id="input-old-password" class="form-control {{ session('password') ? 'is-invalid' : '' }}" name="old_password" required autocomplete="old_password">
    
                                    @if (session('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ session('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group required">
                                <label class="col-sm-2 control-label" for="input-password">{{ __('New Password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" placeholder="{{ __('New Password') }}" id="input-password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password">
    
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
                        </fieldset>
                        <div class="buttons">
                            <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('user.components.accountSideLinks')

    </div>
</div>
<!-- //Main Container -->
@endsection

@section('js')

@endsection
