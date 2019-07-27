@extends('admin.layouts.app')

@section('title')
{{ __('Approve order') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Orders') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('View order') }}</h4> <br>
                    @can('create orders')
                        <a href="{{ route('orders.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new order') }}</a>
                    @endcan
                    @can('update orders')
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    @endcan
                    <a href="{{ route('orders.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
                </div>
                <div class="card-body">
                    @include('admin.components.orderShow')

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('orders.approve', $order->id) }}" method="POST">
                                        @csrf
                                        @if (!$order->isApproved())
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2">{{ __('Warehouse') }}</label>
                                                <div class="input-group col-sm-10">
                                                    <select name="warehouse" class="form-control select2" required>
                                                        <option value="">{{ __('Choose warehouse') }}</option>
                                                        @foreach ($warehouses as $ware)
                                                            <option @if ($ware->id == $order->warehouse_id)
                                                                selected
                                                            @endif value="{{ $ware->id }}">{{ $ware->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2">{{ __('Comment') }}</label>
                                                <div class="input-group col-sm-10">
                                                    <textarea name="comment" placeholder="{{ __('Comment') }}" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-warning">
                                                    <i class="far fa-file-pdf"></i> {{ __('Invoice') }}
                                                </a>
                                                @if (!$order->isApproved())
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ __('Approve') }}</button>
                                                @endif
                                                @if (!$order->isDisapproved())
                                                    <button type="submit" form="disapprove-form" class="btn btn-danger"><i class="fa fa-times"></i> {{ __('Disapprove') }}</button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                    @if (!$order->isDisapproved())
                                        <form id="disapprove-form" action="{{ route('orders.disapprove', $order->id) }}" class="form-inline" method="POST">
                                            @csrf
                                        </form>
                                    @endif
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
