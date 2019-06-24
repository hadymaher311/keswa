@extends('user.layouts.app')

@section('title')
    {{ __('Shopping Cart') }} - {{ config('app.name') }}
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">
    
    <div class="row">
        <!--Middle Part Start-->
    <div id="content" class="col-sm-9">
        <h2 class="title">{{ __('Shopping Cart') }}</h2>
        <div class="table-responsive form-group">
            <table class="table table-bordered">
            <thead>
                <tr>
                <td class="text-center">{{ __('Image') }}</td>
                <td class="">{{ __('Product Name') }}</td>
                <td class="">{{ __('Quantity') }}</td>
                <td class="">{{ __('Unit Price') }}</td>
                <td class="">{{ __('Total Price') }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach (auth()->user()->cart as $cart)
                    <tr>
                        <td class="text-center"><a href="{{ route('user.products.show', [$cart->id, $cart->slug]) }}"><img width="70px" src="{{ $cart->images->first()->getUrl('thumb') }}" alt="{{ $cart->name }}" title="{{ $cart->name }}" class="img-thumbnail" /></a></td>
                        <td class=""><a href="{{ route('user.products.show', [$cart->id, $cart->slug]) }}">{{ $cart->name }}</a><br />
                            </td>
                        <form action="{{ route('user.cart.update', $cart->id) }}" id="update-form-{{ $loop->index }}" method="post">
                            @csrf
                            @method('PUT')
                        </form>
                        <form action="{{ route('user.cart.remove', $cart->id) }}" id="delete-form-{{ $loop->index }}" method="post">
                            @csrf
                            @method('DELETE')
                        </form>
                        <td class="" width="200px"><div class="input-group btn-block quantity">
                            <input type="text" name="quantity" value="{{ $cart->pivot->quantity }}" size="1" class="form-control" form="update-form-{{ $loop->index }}" />
                            <span class="input-group-btn">
                            <button type="submit" data-toggle="tooltip" title="{{ __('Update') }}" form="update-form-{{ $loop->index }}" class="btn btn-primary"><i class="fa fa-clone"></i></button>
                            <button type="submit" data-toggle="tooltip" title="{{ __('Delete') }}" form="delete-form-{{ $loop->index }}" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                        </span></div>
                        </td>
                        <td class="price">
                            @if ($cart->activeDiscount)
                                <span class="price-old">{{ $cart->price }} {{ __('LE') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                @if ($cart->activeDiscount->type == 'value')
                                    <span class="price-new">{{ $cart->price - $cart->activeDiscount->amount }} {{ __('LE') }}</span>
                                @elseif ($cart->activeDiscount->type == 'percentage')
                                    <span class="price-new">{{ ($cart->price * (100 - $cart->activeDiscount->amount) / 100) }} {{ __('LE') }}</span>
                                @endif
                            @else
                                <span>{{ $cart->price }} {{ __('LE') }}</span>
                            @endif
                        </td>
                        <td class="">{{ $cart->pivot->quantity * $cart->final_price }} {{ __('LE') }}</td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    
        <div class="row">
            <div class="col-sm-4 col-sm-offset-8">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-right">
                                <strong>{{ __('Total Price') }}:</strong>
                            </td>
                            <td class="text-right">{{ auth()->user()->cart_total_price }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="buttons">
        <div class="pull-left"><a href="{{ url('/'.app()->getLocale() ) }}" class="btn btn-primary">{{ __('Continue Shopping') }}</a></div>
        <div class="pull-right"><a href="checkout.html" class="btn btn-primary">{{ __('Checkout') }}</a></div>
        </div>
    </div>

    @include('user.components.accountSideLinks')
    <!--Middle Part End -->
        
    </div>
</div>
<!-- //Main Container -->
@endsection