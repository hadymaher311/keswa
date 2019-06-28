@extends('user.layouts.app')

@section('title')
    {{ __('WishList') }} - {{ config('app.name') }}
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">

    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-9">
            <h2 class="title">{{ __('My WishList') }} ({{ auth()->user()->wishlist->count() }})</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-center">{{ __('Image') }}</td>
                            <td class="">{{ __('Name') }}</td>
                            <td class="">{{ __('Stock') }}</td>
                            <td class="">{{ __('Unit Price') }}</td>
                            <td class="">{{ __('Controls') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (auth()->user()->wishlist as $wishlist_product)
                            <tr>
                                <td class="text-center">
                                    <a  href="{{ route('user.products.show', ['product'=> $wishlist_product->id, 'slug' => $wishlist_product->slug]) }}"><img width="70px" src="{{ $wishlist_product->images->first()->getUrl('thumb') }}" alt="{{ $wishlist_product->name }}" title="{{ $wishlist_product->name }}">
                                    </a>
                                </td>
                                <td class=""><a href="{{ route('user.products.show', ['product'=> $wishlist_product->id, 'slug' => $wishlist_product->slug]) }}">{{ $wishlist_product->name }}</a>
                                </td>
                                <td class="">
                                    @if ($wishlist_product->isAvailable())
                                        <span class="status-stock">{{ __('In Stock') }}</span>
                                    @else
                                        <span class="status-stock">{{ __('Out of Stock') }}</span>
                                    @endif
                                </td>
                                <td class="">
                                    <div class="price"> 
                                        @php
                                            $activeDiscount = $wishlist_product->activeDiscount;
                                            $price = $wishlist_product->price;
                                        @endphp
                                        @include('user.components.pricing')
                                    </div>
                                
                                </td>
                                <td class="">
                                    <form style="display: inline-block" action="{{ route('user.cart.store', $wishlist_product->id) }}" method="post">
                                        @csrf
                                        <button class="btn btn-primary"
                                        title="" data-toggle="tooltip"
                                        type="submit" data-original-title="{{ __('Add to Cart') }}"><i class="fa fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                    <form style="display: inline-block" action="{{ route('user.wishlist.remove', $wishlist_product->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="" data-toggle="tooltip" href="" data-original-title="{{ __('Delete') }}"><i class="fa fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @include('user.components.accountSideLinks')

    </div>
</div>
<!-- //Main Container -->
@endsection
