@extends('admin.layouts.app')

@section('title')
{{ __('View user') }}
@endsection

@section('css')
    
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
                    <h4>{{ __('View user') }}</h4> <br>
                    @can('create users')
                        <a href="{{ route('users.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new user') }}</a>
                    @endcan

                    @can('update users')
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan
                    <a href="{{ route('users.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                                    @include('admin.users.navigation')
                                </div>
                            </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card author-box card-primary">
                                    <div class="card-body">
                                        <div class="author-box-left">
                                            @if ($user->image)
                                                <img alt="image" src="{{ $user->image->getUrl('thumb') }}" class="rounded-circle author-box-picture">
                                            @endif
                                        </div>
                                        <div class="author-box-details">
                                        <div class="author-box-name">
                                            <h2>{{ $user->name }}</h2>
                                        </div>
                                        <div class="author-box-description">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    {{ __('Email') }}
                                                </div>
                                                <div class="col sm-3">
                                                    {{ $user->email }}
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