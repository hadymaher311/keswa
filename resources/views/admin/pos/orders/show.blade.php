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
                    <h4>{{ __('View order') }}</h4>
                </div>
                <div class="card-body">
                    @include('admin.components.pos.orderShow')

                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('admin.pos_orders.invoice', $order->id) }}" class="btn btn-warning">
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