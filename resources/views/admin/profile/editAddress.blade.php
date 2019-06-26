@extends('admin.layouts.app')

@section('title')
{{ __('Edit Address') }}
@endsection

@section('css')

@endsection

@section('body')
<div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ auth()->user()->name }}</h4>
                </div>
                <div class="card-body">
                    
                    <div class="section-body">
            
                        <div id="output-status"></div>
                        <div class="row">
                            <div class="col-md-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                <h4>{{ __('Go To') }}</h4>
                                </div>
                                <div class="card-body">
                                    @include('admin.profile.navigation')
                                </div>
                            </div>
                            </div>
                            <div class="col-md-8">
                                <div class="section-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card card-primary">
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
                                                <form action="{{ route('admin.profile.address.edit') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    {{ method_field('PUT') }}
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label" for="input-country">{{ __('Country') }}</label>
                                                        <div class="col-sm-10">
                                                            <select id="input-country" class="form-control @error('country') is-invalid @enderror" name="country" required>
                                                                <option value=""> --- {{ __('Please Select') }} --- </option>')
                                                                <option {{ ((auth()->user()->address) && auth()->user()->address->country == 'Egypt') ? 'selected' : '' }} value="Egypt">{{ __('Egypt') }}</option>
                                                            </select>
                                                            @error('country')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label" for="input-city">{{ __('City') }}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ (auth()->user()->address) ? auth()->user()->address->city : '' }}" required autocomplete="city" placeholder="{{ __('City') }}" id="input-city">
                        
                                                            @error('city')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label" for="input-street">{{ __('Street Name/No') }}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ (auth()->user()->address) ? auth()->user()->address->street : '' }}" required autocomplete="street" placeholder="{{ __('Street Name/No') }}" id="input-street">
                        
                                                            @error('street')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label" for="input-building">{{ __('Building Name/No') }}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('building') is-invalid @enderror" name="building" value="{{ (auth()->user()->address) ? auth()->user()->address->building : '' }}" required autocomplete="building" placeholder="{{ __('Building Name/No') }}" id="input-building">
                        
                                                            @error('building')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label" for="input-floor">{{ __('Floor No') }}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('floor') is-invalid @enderror" name="floor" value="{{ (auth()->user()->address) ? auth()->user()->address->floor : '' }}" required autocomplete="floor" placeholder="{{ __('Floor No') }}" id="input-floor">
                        
                                                            @error('floor')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label" for="input-apartment">{{ __('Apartment No') }}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('apartment') is-invalid @enderror" name="apartment" value="{{ (auth()->user()->address) ? auth()->user()->address->apartment : '' }}" required autocomplete="apartment" placeholder="{{ __('Apartment No') }}" id="input-apartment">
                        
                                                            @error('apartment')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label" for="input-landmark">{{ __('Nearest Landmark') }}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control @error('nearest_landmark') is-invalid @enderror" name="nearest_landmark" value="{{(auth()->user()->address) ?  auth()->user()->address->nearest_landmark : '' }}" autocomplete="nearest_landmark" placeholder="{{ __('Nearest Landmark') }}" id="input-landmark">
                        
                                                            @error('nearest_landmark')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 control-label" for="input-location_type">{{ __('Location Type') }}</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control @error('location_type') is-invalid @enderror" name="location_type" value="{{ (auth()->user()->address) ? auth()->user()->address->location_type : '' }}" required id="input-location_type" class="form-control">
                                                                <option value=""> --- {{ __('Please Select') }} --- </option>
                                                                <option {{ ((auth()->user()->address) ? auth()->user()->address->location_type : '' == 'home') ? 'selected' : '' }} value="home">{{ __('Home/House') }}</option>
                                                                <option {{ ((auth()->user()->address) ? auth()->user()->address->location_type : '' == 'business') ? 'selected' : '' }} value="business">{{ __('Business') }}</option>
                                                            </select>
                                                            @error('location_type')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <button type="submit" class="submit-edit btn btn-warning btn-block">{{ __('Submit') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
</div>

@endsection

@section('js')
@endsection