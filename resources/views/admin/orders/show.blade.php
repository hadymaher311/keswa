@extends('admin.layouts.app')

@section('title')
{{ __('View order') }}
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
                            <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-warning">
                                <i class="far fa-file-pdf"></i> {{ __('Invoice') }}
                            </a>
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