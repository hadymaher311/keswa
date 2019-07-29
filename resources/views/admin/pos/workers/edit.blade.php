@extends('admin.layouts.app')

@section('title')
{{ __('Edit worker') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/select2/dist/css/select2.min.css') }}">    
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.css') }}">    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Workers') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit worker') }}</h4> <br>
                    @can('create pos_workers')
                        <a href="{{ route('workers.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new worker') }}</a>
                    @endcan
                    @can('view pos_workers')
                        <a href="{{ route('workers.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
                    @endcan
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
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                    <form action="{{ route('workers.update', $worker->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('First Name') }}</label>
                            <div class="col-sm-9">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $worker->first_name }}" required autocomplete="first_name" autofocus>

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
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $worker->last_name }}" required autocomplete="last_name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $worker->email }}" required autocomplete="email">

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
                                @endif datepicker @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ ($worker->personalInfo) ? Carbon\Carbon::create($worker->personalInfo->birth_date)->format('Y-m-d') : '' }}" required autocomplete="birth_date" placeholder="{{ __('Date of birth') }}" id="input-date-of-birth" class="form-control">

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
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ ($worker->personalInfo) ? $worker->personalInfo->phone : '' }}" required autocomplete="phone" placeholder="{{ __('Phone Number') }}" id="input-telephone" class="form-control">

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
                                    <option {{ (($worker->personalInfo) && $worker->personalInfo->gender == 'male') ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
                                    <option {{ (($worker->personalInfo) && $worker->personalInfo->gender == 'female') ? 'selected' : '' }} value="female">{{ __('Female') }}</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Image') }}</label>
                            <div class="col-sm-9">
                                <div id="image-preview" class="image-preview"
                                @if ($worker->image)
                                    style="background-image: url('data:{{ $worker->image->meme_type }};base64, {{ config('app.env') == 'local' ? base64_encode(file_get_contents($worker->image->getPath('card'))) : base64_encode(file_get_contents($worker->image->getUrl('card'))) }}'); background-repeat: no-repeat;background-size: cover;
                                    background-position: center center;"
                                @endif
                                >
                                    
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
                            <label for="warehouse" class="col-sm-3 control-label">{{ __('Warehouses') }}</label>
        
                            <div class="col-sm-9">
                                <select name="warehouse" required id="warehouses" class="form-control select2 @error('warehouse') is-invalid @enderror">
                                    <option value="">{{ __('Choose warehouse') }}</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option 
                                            @if ($warehouse->id == $worker->pos->id)
                                                selected
                                            @endif 
                                        value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>

                                @error('warehouse')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="input-country">{{ __('Country') }}</label>
                            <div class="col-sm-9">
                                <select id="input-country" class="form-control @error('country') is-invalid @enderror" name="country" required>
                                    <option value=""> --- {{ __('Please Select') }} --- </option>')
                                    <option {{ ($worker->address && $worker->address->country == 'Egypt') ? 'selected' : '' }} value="Egypt">{{ __('Egypt') }}</option>
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
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $worker->address ? $worker->address->city : '' }}" required autocomplete="city" placeholder="{{ __('City') }}" id="input-city">

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
                                <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ $worker->address ? $worker->address->street : '' }}" required autocomplete="street" placeholder="{{ __('Street Name/No') }}" id="input-street">

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
                                <input type="text" class="form-control @error('building') is-invalid @enderror" name="building" value="{{ $worker->address ? $worker->address->building : '' }}" required autocomplete="building" placeholder="{{ __('Building Name/No') }}" id="input-building">

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
                                <input type="text" class="form-control @error('floor') is-invalid @enderror" name="floor" value="{{ $worker->address ? $worker->address->floor : '' }}" required autocomplete="floor" placeholder="{{ __('Floor No') }}" id="input-floor">

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
                                <input type="text" class="form-control @error('apartment') is-invalid @enderror" name="apartment" value="{{ $worker->address ? $worker->address->apartment : '' }}" required autocomplete="apartment" placeholder="{{ __('Apartment No') }}" id="input-apartment">

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
                                <input type="text" class="form-control @error('nearest_landmark') is-invalid @enderror" name="nearest_landmark" value="{{ $worker->address ? $worker->address->nearest_landmark : '' }}" autocomplete="nearest_landmark" placeholder="{{ __('Nearest Landmark') }}" id="input-landmark">

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
                                <select class="form-control @error('location_type') is-invalid @enderror" name="location_type" required id="input-location_type" class="form-control">
                                    <option value=""> --- {{ __('Please Select') }} --- </option>
                                    <option {{ ($worker->address && $worker->address->location_type == 'home') ? 'selected' : '' }} value="home">{{ __('Home/House') }}</option>
                                    <option {{ ($worker->address && $worker->address->location_type == 'business') ? 'selected' : '' }} value="business">{{ __('Business') }}</option>
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
    <script src="{{ asset('/admin_styles/modules/select2/dist/js/select2.full.min.js') }}"></script>
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