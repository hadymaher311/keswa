@extends('pos.layouts.app')

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
                                @include('pos.profile.navigation')
                            </div>
                        </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card author-box card-primary">
                                <div class="card-body">
                                    <div class="author-box-left">
                                        @if (auth()->user()->image)
                                            <img alt="image" src="{{ auth()->user()->image->getUrl('card') }}" class="rounded-circle author-box-picture">
                                        @else
                                            <img alt="image" src="{{ asset(config('app.default_avatar')) }}" class="rounded-circle author-box-picture">
                                        @endif
                                        <br>
                                        <br>
                                        @error('image')
                                            <div class="alert alert-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                        <div>
                                            <button class="btn btn-primary" id="modal-1">{{ __("Change image") }}</button>
                                        </div>
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
                                                {{ __('Date of birth') }}
                                            </div>
                                            <div class="col-sm-9">
                                                {{ (auth()->user()->personalInfo) ? Carbon\Carbon::create(auth()->user()->personalInfo->birth_date)->format('Y-m-d') : '' }}
                                            </div>
                                            <div class="col-sm-3">
                                                {{ __('Mobile') }}
                                            </div>
                                            <div class="col-sm-9">
                                                {{ (auth()->user()->personalInfo) ? auth()->user()->personalInfo->phone : '' }}
                                            </div>
                                            <div class="col-sm-3">
                                                {{ __('Gender') }}
                                            </div>
                                            <div class="col-sm-9">
                                                {{ (auth()->user()->personalInfo) ? ucfirst(auth()->user()->personalInfo->gender) : '' }}
                                            </div>
                                        </div>

                                        <br>
                                        <br>
                                        <h5>{{ __('Location') }}</h5>
                                        <div class="row">
                                            <div class="col-sm-3"><b>{{ (auth()->user()->address) ? auth()->user()->address->country : '' }}, {{ (auth()->user()->address) ? auth()->user()->address->city : '' }}</b></div>
                                            <div class="col-sm-9"></div>
    
                                            <div class="col-sm-3"><b>{{ __('Location') }}: </b></div>
                                            <div class="col-sm-9">{{ (auth()->user()->address) ? ucfirst(auth()->user()->address->location_type) : '' }}</div>
    
                                            <div class="col-sm-3"><b>{{ __('Street Name/No') }}: </b></div>
                                            <div class="col-sm-9">{{ (auth()->user()->address) ? auth()->user()->address->street : '' }}</div>
    
                                            <div class="col-sm-3"><b>{{ __('Building Name/No') }}: </b></div>
                                            <div class="col-sm-9">{{ (auth()->user()->address) ? auth()->user()->address->building : '' }}</div>
    
                                            <div class="col-sm-3"><b>{{ __('Floor No') }}: </b></div>
                                            <div class="col-sm-9">{{ (auth()->user()->address) ? auth()->user()->address->floor : '' }}</div>
    
                                            <div class="col-sm-3"><b>{{ __('Apartment No') }}: </b></div>
                                            <div class="col-sm-9">{{ (auth()->user()->address) ? auth()->user()->address->apartment : '' }}</div>
    
                                            <div class="col-sm-3"><b>{{ __('Nearest Landmark') }}: </b></div>
                                            <div class="col-sm-9">{{ (auth()->user()->address) ? auth()->user()->address->nearest_landmark : '' }}</div>
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
@include('pos.profile.editImageModal')
@endsection