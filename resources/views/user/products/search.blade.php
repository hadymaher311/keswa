@extends('user.layouts.app')

@section('title')
    {{ __('Products') }} - {{ config('app.name') }}
@endsection

@section('body')
<div class="main-container container" style="margin-top: 4rem;">
    <div id="content">

        <div class="row">
            <!--Left Part Start -->
            <aside class="col-sm-4 col-md-3 content-aside" id="column-left">
                
                @include('user.components.categories')
                
                @include('user.components.latestProducts')
            </aside>
            <!--Left Part End -->
            
            <!--Middle Part Start-->
            <div id="content" class="col-md-9 col-sm-8">
                <div class="products-category">
                    <h3 class="title-category ">{{ __('Search results') }}</h3>
                    <!-- Filters -->
                    <div class="product-filter product-filter-top filters-panel">
                        <div class="row">
                            <div class="col-md-5 col-sm-3 col-xs-12 view-mode">
                                
                                <div class="list-view">
                                    <button class="btn btn-default grid active" data-view="grid" data-toggle="tooltip"  data-original-title="Grid"><i class="fa fa-th"></i></button>
                                    <button class="btn btn-default list" data-view="list" data-toggle="tooltip" data-original-title="List"><i class="fa fa-th-list"></i></button>
                                </div>
                        
                            </div>
                        </div>
                    </div>
                    <!-- //end Filters -->
                    <!--changed listings-->
                    <div class="products-list grid row nopadding-xs so-filter-gird">
                
                        @foreach ($searchResults as $product)
                            <div class="product-layout col-lg-15 col-md-4 col-sm-6 col-xs-12">
                                <div class="product-item-container">
                                    <div class="left-block">
                                        <div class="product-image-container second_img" style="height: 170px;">
                                            <a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" target="_self" title="{{ $product->name }}">
                                                <img src="{{ $product->images->first()->getUrl('card') }}" class="img-1 img-responsive" alt="{{ $product->name }}">
                                                @if (count($product->images) > 1)
                                                    <img src="{{ $product->images[1]->getUrl('card') }}" class="img-2 img-responsive" alt="{{ $product->name }}">
                                                @endif
                                            </a>
                                        </div>
                                        @if ($product->activeDiscount)
                                            <div class="box-label"> <span class="label-product label-sale"> -{{ $product->discount_percentage }}% </span></div>
                                        @endif
                                        <div class="button-group so-quickview cartinfo--left">
                                            @php
                                                $product_id = $product->id;
                                            @endphp
                                            @include('user.components.productButtons')
                                        </div>
                                    </div>
                                    <div class="right-block">
                                        <div class="caption">
                                            <div class="rating">
                                                @php
                                                    $rating = $product->rating;
                                                @endphp
                                                @include('user.components.rating')
                                            </div>
                                            <h4><a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" title="{{ $product->name }} " target="_self">{{ $product->name }} </a></h4>
                                            <div class="price">
                                                @if ($product->activeDiscount)
                                                    <span class="price-old">{{ $product->price }} {{ __('LE') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @if ($product->activeDiscount->type == 'value')
                                                        <span class="price-new">{{ $product->price - $product->activeDiscount->amount }} {{ __('LE') }}</span>
                                                    @elseif ($product->activeDiscount->type == 'percentage')
                                                        <span class="price-new">{{ ($product->price * (100 - $product->activeDiscount->amount) / 100) }} {{ __('LE') }}</span>
                                                    @endif
                                                @else
                                                    <span>{{ $product->price }} {{ __('LE') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    {{-- {{ $searchResults->links() }} --}}
                    <!--// End Changed listings-->
                    
                </div>
                
            </div>
            
        </div>
        <!--Middle Part End-->
    </div>
</div>
<!-- //Main Container -->
@endsection

@section('js')
<script>
    $(function() {
        $("#input-sort").on('change', function() {
            $(this).parents('form').submit();
        })
    })
</script>
@endsection
