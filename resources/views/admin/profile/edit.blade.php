@extends('admin.layouts.app')

@section('title')
{{ __('Edit admin') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
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
                                                <form action="{{ route('admin.profile.edit') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    {{ method_field('PUT') }}
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">{{ __('First Name') }}</label>
                                                        <div class="col-sm-9">
                                                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ auth()->user()->first_name }}" required autocomplete="first_name" autofocus>

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
                                                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ auth()->user()->last_name }}" required autocomplete="last_name" autofocus>

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
                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" required autocomplete="email">

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
                                                            @endif datepicker @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ (auth()->user()->personalInfo) ? Carbon\Carbon::create(auth()->user()->personalInfo->birth_date)->format('Y-m-d') : '' }}" required autocomplete="birth_date" placeholder="{{ __('Date of birth') }}" id="input-date-of-birth" class="form-control">
                            
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
                                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ (auth()->user()->personalInfo) ? auth()->user()->personalInfo->phone : '' }}" required autocomplete="phone" placeholder="{{ __('Phone Number') }}" id="input-telephone" class="form-control">
                            
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
                                                            <select class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ (auth()->user()->personalInfo) ? auth()->user()->personalInfo->gender : '' }}" required id="input-gender" class="form-control">
                                                                <option value=""> --- {{ __('Please Select') }} --- </option>
                                                                <option {{ ((auth()->user()->personalInfo) && auth()->user()->personalInfo->gender == 'male') ? 'selected' : '' }} value="male">{{ __('Male') }}</option>
                                                                <option {{ ((auth()->user()->personalInfo) && auth()->user()->personalInfo->gender == 'female') ? 'selected' : '' }} value="female">{{ __('Female') }}</option>
                                                            </select>
                                                            @error('gender')
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
<script src="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endsection