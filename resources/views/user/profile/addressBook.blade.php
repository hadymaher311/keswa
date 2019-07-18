@extends('user.layouts.app')

@section('title')
    {{ auth()->user()->name }} - {{ __('Addresses') }} - {{ config('app.name') }}
@endsection

@section('css')
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">

    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-9">
            <h2 class="title">{{ __('My Addresses') }}</h2>
            <h3>{{ __('Hi') }}, <b>{{ auth()->user()->name }}</b></h3>
            <div class="row">
                @foreach (auth()->user()->addresses as $address)                    
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form action="{{ route('user.addresses.delete', $address->id) }}" id="delete-form-{{ $loop->index }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="{{ route('user.addresses.edit', $address->id) }}" class="btn btn-link btn-xs pull-right"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                                @if ($address->id != auth()->user()->main_location)
                                    <a href="{{ route('user.addresses.main_location', $address->id) }}" class="btn btn-primary btn-xs pull-right"><i class="fa fa-home"></i> {{ __('Choose as main location') }}</a>
                                    <button class="btn btn-danger btn-xs pull-right" type="submit" form="delete-form-{{ $loop->index }}"><i class="fa fa-times"></i> {{ __('Delete') }}</button>
                                @endif
                                <div>
                                    <b>{{ $address->country }}, {{ $address->warehouse_related_location->location_name }}</b>
                                </div>
                                <div>
                                    <b>{{ __('Location') }}: </b>{{ __(ucfirst($address->location_type)) }}
                                </div>
                                <div>
                                    <b>{{ __('Street Name/No') }}: </b>{{ $address->street }}
                                </div>
                                <div>
                                    <b>{{ __('Building Name/No') }}: </b>{{ $address->building }}
                                </div>
                                <div>
                                    <b>{{ __('Floor No') }}: </b>{{ $address->floor }}
                                </div>
                                <div>
                                    <b>{{ __('Apartment No') }}: </b>{{ $address->apartment }}
                                </div>
                                <div>
                                    <b>{{ __('Nearest Landmark') }}: </b>{{ $address->nearest_landmark }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-sm-12">
                    <form action="{{ route('user.addresses.store') }}" method="post" class="form-horizontal account-register clearfix">
                        @csrf
                        <fieldset id="address">
                            <legend>{{ __('Add new Address') }}</legend>
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
                                    <select name="city" id="input-city" class="form-control @error('city') is-invalid @enderror" name="city" required>
                                        <option value=""> --- {{ __('Please Select') }} --- </option>')
                                        @foreach ($locations as $location)
                                            <option @if (old('city') == $location->id)
                                                selected
                                            @endif value="{{ $location->id }}">{{ $location->location_name }}</option>
                                        @endforeach
                                    </select>

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
