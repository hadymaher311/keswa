@extends('admin.layouts.app')

@section('title')
{{ __('View worker') }}
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
                    <h4>{{ __('View worker') }}</h4> <br>
                    @can('create pos_workers')
                        <a href="{{ route('workers.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new admin') }}</a>
                    @endcan
                    
                    @can('update pos_workers')
                        <a href="{{ route('workers.edit', $worker->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan
                    <a href="{{ route('workers.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                                <img alt="image" src="{{ ($worker->image) ? $worker->image->getUrl('thumb') : asset(config('app.default_avatar')) }}" class="rounded-circle author-box-picture">
                            </div>
                            <div class="author-box-details">
                            <div class="author-box-name">
                                <h2>{{ $worker->name }}</h2>
                            </div>
                            <div class="author-box-description">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <b>{{ __('Email') }}</b>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $worker->email }}
                                    </div>
                                    <div class="col-sm-3">
                                        {{ __('Date of birth') }}
                                    </div>
                                    <div class="col-sm-9">
                                        {{ ($worker->personalInfo) ? Carbon\Carbon::create($worker->personalInfo->birth_date)->format('Y-m-d') : '' }}
                                    </div>
                                    <div class="col-sm-3">
                                        {{ __('Mobile') }}
                                    </div>
                                    <div class="col-sm-9">
                                        {{ ($worker->personalInfo) ? $worker->personalInfo->phone : '' }}
                                    </div>
                                    <div class="col-sm-3">
                                        {{ __('Gender') }}
                                    </div>
                                    <div class="col-sm-9">
                                        {{ ($worker->personalInfo) ? ucfirst($worker->personalInfo->gender) : '' }}
                                    </div>
                                </div>

                                <br>
                                <h5>{{ __('Location') }}</h5>
                                <div class="row">
                                    <div class="col-sm-3"><b>{{ ($worker->address) ? $worker->address->country : '' }}, {{ ($worker->address) ? $worker->address->city : '' }}</b></div>
                                    <div class="col-sm-9"></div>

                                    <div class="col-sm-3"><b>{{ __('Location') }}: </b></div>
                                    <div class="col-sm-9">{{ ($worker->address) ? ucfirst($worker->address->location_type) : '' }}</div>

                                    <div class="col-sm-3"><b>{{ __('Street Name/No') }}: </b></div>
                                    <div class="col-sm-9">{{ ($worker->address) ? $worker->address->street : '' }}</div>

                                    <div class="col-sm-3"><b>{{ __('Building Name/No') }}: </b></div>
                                    <div class="col-sm-9">{{ ($worker->address) ? $worker->address->building : '' }}</div>

                                    <div class="col-sm-3"><b>{{ __('Floor No') }}: </b></div>
                                    <div class="col-sm-9">{{ ($worker->address) ? $worker->address->floor : '' }}</div>

                                    <div class="col-sm-3"><b>{{ __('Apartment No') }}: </b></div>
                                    <div class="col-sm-9">{{ ($worker->address) ? $worker->address->apartment : '' }}</div>

                                    <div class="col-sm-3"><b>{{ __('Nearest Landmark') }}: </b></div>
                                    <div class="col-sm-9">{{ ($worker->address) ? $worker->address->nearest_landmark : '' }}</div>
                                </div>

                                <br>
                                <h5>{{ __('Warehouse') }}</h5>
                                <div class="row">
                                    <div class="col-sm-3"><b>{{ __('Warehouse') }}:</b></div>
                                    <div class="col-sm-9">
                                        <a href="{{ route('warehouses.show', $worker->pos->id) }}" class="badge badge-primary" style="margin: 5px">{{ $worker->pos->name }}</a>
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