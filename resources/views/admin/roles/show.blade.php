@extends('admin.layouts.app')

@section('title')
{{ __('View role') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Roles') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('View role') }}</h4> <br>
                    @can('create roles')
                        <a href="{{ route('roles.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new role') }}</a>
                    @endcan
                    @can('update roles')
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan
                    <a href="{{ route('roles.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                    
                    <div class="row">
                        <div class="col-sm-3"><b>{{ __('Name') }}:</b></div>
                        <div class="col-sm-9">{{ $role->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><b>{{ __('Permissions') }}:</b></div>
                        <div class="col-sm-9">
                            @foreach ($role->permissions as $permission)
                                <div class="badge badge-primary mt-3">{{ $permission->name }}</div>
                            @endforeach
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