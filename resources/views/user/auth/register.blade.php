@extends('user.layouts.app')

@section('title')
    {{ __('Register') }}
@endsection

@section('body')
    <!-- Main Container  -->
	<div class="main-container container">
        
        <div class="row">
            <div id="content" class="col-sm-12">
                <h2 class="title">{{ __('Register Account') }}</h2>
                <p>{{ __('If you already have an account with us, please login at the') }} <a href="{{ route('login') }}">{{ __('login page') }}</a>.</p>
                <form action="{{ route('register') }}" method="post" enctype="multipart/form-data" class="form-horizontal account-register clearfix">
                    @csrf
                    <fieldset id="account">
                        <legend>{{ __('Your Personal Details') }}</legend>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-firstname">{{ __('First Name') }}</label>
                            <div class="col-sm-10">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" placeholder="{{ __('First Name') }}" autofocus>
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
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" placeholder="{{ __('Last Name') }}" id="input-lastname">

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
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" id="input-email">

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
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="{{ __('Phone Number') }}" id="input-telephone" class="form-control">

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
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ old('gender') }}" required id="input-gender" class="form-control">
                                    <option value=""> --- {{ __('Please Select') }} --- </option>
                                    <option {{ (old('gender') == 'male') ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
                                    <option {{ (old('gender') == 'female') ? 'selected' : '' }} value="female">{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id="address">
                        <legend>{{ __('Your Address') }}</legend>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-country">{{ __('Country') }}</label>
                            <div class="col-sm-10">
                                <select id="input-country" class="form-control @error('country') is-invalid @enderror" name="country" required>
                                    <option value=""> --- {{ __('Please Select') }} --- </option>')
                                    <option {{ (old('country') == 'Egypt') ? 'selected' : '' }} value="Egypt">{{ __('Egypt') }}</option>
                                </select>
                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-city">{{ __('City') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city" placeholder="{{ __('City') }}" id="input-city">

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-street">{{ __('Street Name/No') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street" placeholder="{{ __('Street Name/No') }}" id="input-street">

                                @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-building">{{ __('Building Name/No') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('building') is-invalid @enderror" name="building" value="{{ old('building') }}" required autocomplete="building" placeholder="{{ __('Building Name/No') }}" id="input-building">

                                @error('building')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-floor">{{ __('Floor No') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('floor') is-invalid @enderror" name="floor" value="{{ old('floor') }}" required autocomplete="floor" placeholder="{{ __('Floor No') }}" id="input-floor">

                                @error('floor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-apartment">{{ __('Apartment No') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('apartment') is-invalid @enderror" name="apartment" value="{{ old('apartment') }}" required autocomplete="apartment" placeholder="{{ __('Apartment No') }}" id="input-apartment">

                                @error('apartment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input-landmark">{{ __('Nearest Landmark') }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('nearest_landmark') is-invalid @enderror" name="nearest_landmark" value="{{ old('nearest_landmark') }}" autocomplete="nearest_landmark" placeholder="{{ __('Nearest Landmark') }}" id="input-landmark">

                                @error('nearest_landmark')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-2 control-label" for="input-location_type">{{ __('Location Type') }}</label>
                            <div class="col-sm-10">
                                <select class="form-control @error('location_type') is-invalid @enderror" name="location_type" value="{{ old('location_type') }}" required id="input-location_type" class="form-control">
                                    <option value=""> --- {{ __('Please Select') }} --- </option>
                                    <option {{ (old('location_type') == 'home') ? 'selected' : '' }} value="home">{{ __('Home/House') }}</option>
                                    <option {{ (old('location_type') == 'business') ? 'selected' : '' }} value="business">{{ __('Business') }}</option>
                                </select>
                                @error('location_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>{{ __('Your Password') }}</legend>
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
                    </fieldset>
                    <div class="buttons">
                            <input type="submit" value="{{ __('Register') }}" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //Main Container -->
@endsection
