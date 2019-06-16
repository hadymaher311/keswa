@extends('admin.layouts.app')

@section('title')
    {{ __('Profile') }}
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
                            <div class="card author-box card-primary">
                                <div class="card-body">
                                    <div class="author-box-left">
                                        @if (auth()->user()->image)
                                            <img alt="image" src="{{ auth()->user()->image->getUrl('card') }}" class="rounded-circle author-box-picture">
                                        @endif
                                    </div>
                                    <div class="author-box-details">
                                    <div class="author-box-name">
                                        <h2>{{ auth()->user()->name }}</h2>
                                    </div>
                                    <div class="author-box-description">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                {{ __('Email') }}
                                            </div>
                                            <div class="col sm-3">
                                                {{ auth()->user()->email }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                {{ __('Role') }}
                                            </div>
                                            <div class="col sm-3">
                                                {{ auth()->user()->roles->first()->name }}
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