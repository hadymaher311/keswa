@extends('pos.layouts.app')

@section('title')
{{ __('Edit worker') }}
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
                                    @include('pos.profile.navigation')
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
                                                    <form action="{{ route('pos.profile.edit.password') }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">{{ __('Password') }}</label>
                                                            <div class="col-sm-9">
                                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autofocus autocomplete="new-password">

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
                                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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