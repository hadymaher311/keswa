@extends('pos.layouts.app')

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
                    <a href="{{ route('pos_orders.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new order') }}</a>
                    <a href="{{ route('pos_orders.edit', $order->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                    <a href="{{ route('pos_orders.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
                </div>
                <div class="card-body">
                    @include('pos.components.orderShow')

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('pos_orders.complete', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2">{{ __('Comment') }}</label>
                                            <div class="input-group col-sm-10">
                                                <textarea name="comment" placeholder="{{ __('Comment') }}" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="{{ route('pos_orders.invoice', $order->id) }}" class="btn btn-primary">
                                                    <i class="far fa-file-pdf"></i> {{ __('Invoice') }}
                                                </a>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ __('Approve') }}</button>
                                                <a href="{{ route('pos_orders.edit', $order->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Back to edit') }}</a>
                                                <button type="submit" onclick="
                                                event.preventDefault();
                                                if(confirm('{{ __('Are you sure?') }}')) {
                                                    $(this).parent('form').submit();
                                                }" form="cancel-form" class="btn btn-danger"><i class="fa fa-times"></i> {{ __('Cancel') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="cancel-form" action="{{ route('pos_orders.destroy') }}" class="form-inline" method="POST">
                                        @csrf
                                        <input type="hidden" name="orders[]" value="{{ $order->id }}">
                                    </form>
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
