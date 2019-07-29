@extends('admin.layouts.app')

@section('title')
{{ __('Edit worker') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Workers') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit worker') }}</h4> <br>
                    @can('create pos_worker')
                        <a href="{{ route('workers.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new admin') }}</a>
                    @endcan

                    @can('update pos_worker')
                        <a href="{{ route('workers.edit', $admin->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan

                    @can('view pos_worker')
                        <a href="{{ route('workers.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                    <form action="{{ route('workers.edit.password', $worker->id) }}" method="post">
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

@endsection

@section('js')
@endsection