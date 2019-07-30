@extends('admin.layouts.app')

@section('title')
    {{ __('General Settings') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">    
@endsection

@section('body')

<div class="section-header">
    <h1>{{ __('General Settings') }}</h1>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
                <div class="card">
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
                    <form action="{{ route('admin.general.settings.price.tax') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 mt-3 col-form-label">{{ __('Price Tax') }} ({{ __('Percentage') }})</label>
                            <div class="col-sm-6 mt-3">
                                <input id="price_tax" type="number" min="0" class="form-control @error('price_tax') is-invalid @enderror" name="price_tax" value="{{ ($price_tax) ? $price_tax->value : 0 }}" autocomplete="price_tax" autofocus>
                                
                                @error('price_tax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-3 mt-3">
                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                    
                    <form action="{{ route('admin.general.settings.working.hours') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 mt-3 col-form-label">{{ __('Working Hours') }} ({{ __('From - To') }})</label>
                            <div class="col-sm-3 mt-3">
                                <input id="working_hours_from" type="text" class="form-control timepicker @error('working_hours_from') is-invalid @enderror" name="working_hours_from" value="{{ ($working_hours_from) ? $working_hours_from->value : now()->format('H:i A') }}" autocomplete="working_hours_from">
                                
                                @error('working_hours_from')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-3 mt-3">
                                <input id="working_hours_to" type="text" class="form-control timepicker @error('working_hours_to') is-invalid @enderror" name="working_hours_to" value="{{ ($working_hours_to) ? $working_hours_to->value : now()->format('H:i A') }}" autocomplete="working_hours_to">
                                
                                @error('working_hours_to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-3 mt-3">
                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>

                    <form action="{{ route('admin.general.settings.points.value') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 mt-3 col-form-label">{{ __('Points Value') }} ({{ __('points per LE') }})</label>
                            <div class="col-sm-6 mt-3">
                                <input id="points_value" type="number" min="0" class="form-control @error('points_value') is-invalid @enderror" name="points_value" value="{{ ($points_value) ? $points_value->value : 1 }}" autocomplete="points_value" autofocus>
                                
                                @error('points_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-3 mt-3">
                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>

                    <form action="{{ route('admin.general.settings.update.pos.orders') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 mt-3 col-form-label">{{ __('Enable update orders in POS') }}</label>
                            <div class="col-sm-6 mt-3">
                                <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if (isset($update_pos_orders) && $update_pos_orders->value == 1)
                                    {{ __('Active') }}
                                    @else
                                    {{ __('Not Active') }}
                                    @endif">
                                    <input name="active" type="checkbox" @if (isset($update_pos_orders) && $update_pos_orders->value == 1)
                                    checked
                                    @endif class="custom-switch-input" onchange="
                                        $(this).parent('form'),submit();
                                    ">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                                
                                @error('points_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-3 mt-3">
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
<script src="{{ asset('/admin_styles/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
@endsection