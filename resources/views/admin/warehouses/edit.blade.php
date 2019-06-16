@extends('admin.layouts.app')

@section('title')
{{ __('Edit warehouse') }}
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
                    <h4>{{ __('Edit warehouse') }}</h4> <br>
                    @can('create warehouses')
                        <a href="{{ route('warehouses.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new warehouse') }}</a>
                    @endcan

                    @can('view warehouses')
                        <a href="{{ route('warehouses.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                    <form action="{{ route('warehouses.update', $warehouse->id) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Name') }} {{ __('in English') }}</label>
                            <div class="col-sm-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $warehouse->name_en }}" autocomplete="name" autofocus>
                                
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Name') }} {{ __('in Arabic') }}</label>
                            <div class="col-sm-9">
                                <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{ $warehouse->name_ar }}" autocomplete="name_ar">
                                
                                @error('name_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Location') }} {{ __('in English') }}</label>
                            <div class="col-sm-9">
                                <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ $warehouse->location_en }}" required autocomplete="location">
                                
                                @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Location') }} {{ __('in Arabic') }}</label>
                            <div class="col-sm-9">
                                <input id="location_ar" type="text" class="form-control @error('location_ar') is-invalid @enderror" name="location_ar" value="{{ $warehouse->location_ar }}" autocomplete="location_ar">
                                
                                @error('location_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
@endsection