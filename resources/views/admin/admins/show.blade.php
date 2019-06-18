@extends('admin.layouts.app')

@section('title')
{{ __('View admin') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Admins') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('View admin') }}</h4> <br>
                    @can('create admins')
                        <a href="{{ route('admins.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new admin') }}</a>
                    @endcan
                    
                    @can('update admins')
                        <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan
                    <a href="{{ route('admins.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                    
                    <div class="card author-box card-primary">
                        <div class="card-body">
                            <div class="author-box-left">
                                <img alt="image" src="{{ $admin->image->getUrl('thumb') }}" class="rounded-circle author-box-picture">
                            </div>
                            <div class="author-box-details">
                            <div class="author-box-name">
                                <h2>{{ $admin->name }}</h2>
                            </div>
                            <div class="author-box-job">{{ __('Role') }}: {{ $admin->roles->first()->name }}</div>
                            <div class="author-box-description">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <b>{{ __('Email') }}</b>
                                    </div>
                                    <div class="col sm-3">
                                        {{ $admin->email }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"><b>{{ __('Permissions') }}:</b></div>
                                    <div class="col-sm-9">
                                        @php
                                            $permissionsArray = array();
                                        @endphp
                                        @foreach ($admin->roles->first()->permissions as $permission)
                    
                                            @if (!in_array(explode(' ', $permission->name)[1], $permissionsArray))
                                                
                                                <div class="check-all-container">
                                                <div style="clear: both;"></div>
                                                <b>{{ ucfirst(explode(' ', $permission->name)[1]) }}:</b> <br>
                                                <div class="row">
                                                    @foreach ($admin->roles->first()->permissions as $permission2)
                        
                                                        @if (explode(' ', $permission->name)[1] === explode(' ', $permission2->name)[1])
                        
                                                            <div class="badge badge-primary" style="margin: 5px">{{ $permission2->name }}</div>
                        
                                                        @endif
                        
                                                    @endforeach
                                                </div>
                                                </div>
                                                
                                                @php
                                                    $permissionsArray[] = explode(' ', $permission->name)[1];
                                                @endphp
                    
                                            @endif
                                        @endforeach
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