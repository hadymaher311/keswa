@extends('admin.layouts.app')

@section('title')
{{ __('Settings') }}
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
                                                    <form action="{{ route('admin.profile.edit.language') }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-sm-2 mt-3 col-form-label">{{ __('Language') }}</label>
                                                            <div class="col-sm-5 mt-3">
                                                                @php
                                                                    $locales = [
                                                                        'en' => 'English', 
                                                                        'ar' => 'Arabic'
                                                                    ]
                                                                @endphp
                                                                <select id="language" type="language" class="form-control @error('language') is-invalid @enderror" name="language" required autofocus autocomplete="new-language">
                                                                    @foreach ($locales as $locale => $value)
                                                                        <option value="{{ $locale }}" @if ($locale == app()->getLocale())
                                                                            selected
                                                                        @endif>{{ __($value) }}</option>
                                                                    @endforeach
                                                                </select>

                                                                @error('language')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-sm-5 mt-3">
                                                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
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