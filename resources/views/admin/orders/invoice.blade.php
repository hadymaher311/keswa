@extends('admin.layouts.app')

@section('title')
{{ __('Invoice') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Orders') }}</h1>
        <a target="_blank" href="{{ route('orders.invoice.print', $order->id) }}" class="btn btn-warning btn-icon ml-3 mr-3 icon-left"><i class="fas fa-print"></i> Print</a>
    </div>

    <div class="section-body">
        @include('admin.components.invoice')
    </div>

@endsection

@section('js')
@endsection