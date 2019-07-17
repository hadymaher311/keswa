@extends('admin.layouts.app')

@section('title')
{{ __('Add new user') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.css') }}">    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Users') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add new user') }}</h4> <br>
                </div>
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
                    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('First Name') }}</label>
                            <div class="col-sm-9">
                                <input id="first_name" type="text" placeholder="{{ __('First Name') }}" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>

                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Last Name') }}</label>
                            <div class="col-sm-9">
                                <input id="last_name" type="text" placeholder="{{ __('Last Name') }}" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>

                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                            <div class="col-sm-9">
                                <input id="email" type="email" placeholder="{{ __('Email') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-date-of-birth">{{ __('Date of birth') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @if (app()->getLocale() == 'ar')
                                pull-right
                                @endif datepicker @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" placeholder="{{ __('Date of birth') }}" id="input-date-of-birth" class="form-control">

                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-telephone">{{ __('Phone Number') }}</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="{{ __('Phone Number') }}" id="input-telephone" class="form-control">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-gender">{{ __('Gender') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender" required id="input-gender" class="form-control">
                                    <option value=""> --- {{ __('Please Select') }} --- </option>
                                    <option {{ old('gender') == 'male' ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
                                    <option {{ old('gender') == 'female' ? 'selected' : '' }} value="female">{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Password') }}</label>
                            <div class="col-sm-9">
                                <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Confirm Password') }}</label>
                            <div class="col-sm-9">
                                <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Image') }}</label>
                            <div class="col-sm-9">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">{{ __('Choose Image') }}</label>
                                    <input type="file" accept="image/*" name="image" id="image-upload" />
                                    
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-country">{{ __('Country') }}</label>
                            <div class="col-sm-9">
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
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-city">{{ __('City') }}</label>
                            <div class="col-sm-9">
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
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-street">{{ __('Street Name/No') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street" placeholder="{{ __('Street Name/No') }}" id="input-street">

                                @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-building">{{ __('Building Name/No') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('building') is-invalid @enderror" name="building" value="{{ old('building') }}" required autocomplete="building" placeholder="{{ __('Building Name/No') }}" id="input-building">

                                @error('building')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-floor">{{ __('Floor No') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('floor') is-invalid @enderror" name="floor" value="{{ old('floor') }}" required autocomplete="floor" placeholder="{{ __('Floor No') }}" id="input-floor">

                                @error('floor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-apartment">{{ __('Apartment No') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('apartment') is-invalid @enderror" name="apartment" value="{{ old('apartment') }}" required autocomplete="apartment" placeholder="{{ __('Apartment No') }}" id="input-apartment">

                                @error('apartment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-landmark">{{ __('Nearest Landmark') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('nearest_landmark') is-invalid @enderror" name="nearest_landmark" value="{{ old('nearest_landmark') }}" autocomplete="nearest_landmark" placeholder="{{ __('Nearest Landmark') }}" id="input-landmark">

                                @error('nearest_landmark')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-location_type">{{ __('Location Type') }}</label>
                            <div class="col-sm-9">
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
                        
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/admin_styles/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>
        $.uploadPreview({
            input_field: "#image-upload",   // Default: .image-upload
            preview_box: "#image-preview",  // Default: .image-preview
            label_field: "#image-label",    // Default: .image-label
            label_default: "{{ __('Choose Image') }}",   // Default: {{ __('Choose Image') }}
            label_selected: "{{ __('Change Image') }}",  // Default: Change File
            no_label: false,                // Default: false
            success_callback: null          // Default: null
        });
    </script>
@endsection