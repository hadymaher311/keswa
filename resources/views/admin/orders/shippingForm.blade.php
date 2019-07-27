@extends('admin.layouts.app')

@section('title')
{{ __('Shipping order') }}
@endsection

@section('css')    
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/select2/dist/css/select2.min.css') }}">    
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
                    <h4>{{ __('Shipping order') }}</h4> <br>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('orders.shipping', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2">{{ __('Delivery men') }}</label>
                                            <div class="input-group col-sm-10">
                                                <select name="delivery" class="form-control select2" required>
                                                    <option value="">{{ __('Choose delivery man') }}</option>
                                                    @foreach ($admins as $admin)
                                                        <option @if ($admin->id == $order->delivery_id)
                                                            selected
                                                        @endif value="{{ $admin->id }}">{{ $admin->name }} - {{ $admin->email }}</option>
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

                                        <div class="row">
                                            <div class="col-12">
                                                <a href="{{ route('orders.invoice', $order->id) }}" class="btn btn-warning">
                                                    <i class="far fa-file-pdf"></i> {{ __('Invoice') }}
                                                </a>

                                                <button type="submit" class="btn btn-success"><i class="fa fa-shipping-fast"></i> {{ __('Shipping') }}</button>
                                            </div>
                                        </div>
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
<script src="{{ asset('/admin_styles/modules/select2/dist/js/select2.full.min.js') }}"></script>
@endsection
