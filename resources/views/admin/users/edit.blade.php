@extends('admin.layouts.app')

@section('title')
{{ __('Edit user') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.css') }}">        
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('User') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit user') }}</h4> <br>
                    @can('create users')
                        <a href="{{ route('users.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new user') }}</a>
                    @endcan

                    @can('view users')
                        <a href="{{ route('users.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                    <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('First Name') }}</label>
                            <div class="col-sm-9">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" required autocomplete="first_name" autofocus>

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
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

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
                                @endif datepicker @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ ($user->personalInfo) ? Carbon\Carbon::create($user->personalInfo->birth_date)->format('Y-m-d') : '' }}" required autocomplete="birth_date" placeholder="{{ __('Date of birth') }}" id="input-date-of-birth" class="form-control">

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
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ ($user->personalInfo) ? $user->personalInfo->phone : '' }}" required autocomplete="phone" placeholder="{{ __('Phone Number') }}" id="input-telephone" class="form-control">

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
                                    <option {{ (($user->personalInfo) && $user->personalInfo->gender == 'male') ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
                                    <option {{ (($user->personalInfo) && $user->personalInfo->gender == 'female') ? 'selected' : '' }} value="female">{{ __('Female') }}</option>
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
                                @if ($user->image)
                                    style="background-image: url('data:{{ $user->image->meme_type }};base64, {{ config('app.env') == 'local' ? base64_encode(file_get_contents($user->image->getPath('card'))) : base64_encode(file_get_contents($user->image->getUrl('card'))) }}'); background-repeat: no-repeat;background-size: cover;
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