@extends('admin.layouts.app')

@section('title')
{{ __('View warehouse') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Warehouses') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('View warehouse') }}</h4> <br>
                    @can('create warehouses')
                        <a href="{{ route('warehouses.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new warehouse') }}</a>
                    @endcan

                    @can('update warehouses')
                        <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan
                    <a href="{{ route('warehouses.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                        <div class="col-sm-9">{{ $warehouse->name }}</div>
                        <div class="col-sm-3"><b>{{ __('Location') }}:</b></div>
                        <div class="col-sm-9">{{ $warehouse->location }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('js')
@endsection