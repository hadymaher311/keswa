@extends('user.layouts.app')

@section('title')
    {{ config('app.name') }}
@endsection

@section('body')
<div class="main-container container">
    <div id="content">
        <div class="row">
            
            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 main-left sidebar-offcanvas">
                <div class="module col1 hidden-sm hidden-xs"></div>

                <div class="module product-simple">
                    <h3 class="modtitle">
                        <span>{{ __('Top Rated') }}</span>
                    </h3>
                    <div class="modcontent">
                        <div id="so_extra_slider_2" class="extraslider" >
                            <!-- Begin extraslider-inner -->
                            <div class="yt-content-slider extraslider-inner" data-rtl="yes" data-pagination="yes" data-autoplay="no" data-delay="4" data-speed="0.6" data-margin="0" data-items_column0="1" data-items_column1="1" data-items_column2="1" data-items_column3="1" data-items_column4="1" data-arrows="no"
                            data-lazyload="yes" data-loop="no" data-buttonpage="top">
                                <div class="item ">
                                    @foreach ($top_rated_products as $product)
                                        <div class="product-layout item-inner style1 ">
                                            <div class="item-image">
                                                <div class="item-img-info">
                                                    <a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" target="_self" title="{{ $product->name }} ">
                                                        <img src="{{ $product->images->first()->getUrl('card') }}" alt="{{ $product->name }}">
                                                        </a>
                                                </div>
                                                
                                            </div>
                                            <div class="item-info">
                                                <div class="item-title">
                                                    <a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" target="_self" title="{{ $product->name }}">{{ $product->name }} </a>
                                                </div>
                                                <div class="rating">
                                                    @php $rating = $product->rating; @endphp  

                                                    @foreach(range(1,5) as $i)
                                                        <span class="fa-stack">
                                                            <i class="fa fa-star-o fa-stack-2x"></i>
                                        
                                                            @if($rating >0)
                                                                @if($rating >0.5)
                                                                    <i class="fa fa-star fa-stack-2x"></i>
                                                                @else
                                                                    <i style="color: #ff9600;" class="fa fa-star-half-o fa-stack-2x"></i>
                                                                @endif
                                                            @endif
                                                            @php $rating--; @endphp
                                                        </span>
                                                    @endforeach
                                                </div>
                                                <div class="content_price price">
                                                    @php
                                                        $activeDiscount = $product->activeDiscount;
                                                        $price = $product->price;
                                                    @endphp
                                                    @include('user.components.pricing')
                                                </div>
                                            </div>
                                            <!-- End item-info -->
                                            <!-- End item-wrap-inner -->
                                        </div>
                                        <!-- End item-wrap -->
                                    @endforeach
                                </div>
                            </div>
                            <!--End extraslider-inner -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 main-right">

                <!-- Deals -->
                <div class="module deals-layout1">
                    <h3 class="modtitle"><span>{{ __('Best Discounts') }}</span></h3>
                    <div class="modcontent">
                        <div id="so_deal_1" class="so-deal style2">
                            <div class="extraslider-inner products-list yt-content-slider" data-rtl="yes" data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column0="2" data-items_column1="1" data-items_column2="1"  data-items_column3="1" data-items_column4="1" data-arrows="yes" data-pagination="yes" data-lazyload="yes" data-loop="no" data-hoverpause="yes">

                                @foreach ($best_discount_products as $product)
                                    <div class="item">
                                        <div class="product-thumb">
                                            <div class="row">
                                                <div class="inner">
                                                    <div class="item-left col-lg-6 col-md-5 col-sm-5 col-xs-12">
                                                        <div class="image"> 
                                                            @if ($product->discount_percentage > 0)
                                                                <span class="label-product label-product-sale">
                                                                    -{{ $product->discount_percentage }}%
                                                                </span>
                                                            @endif
                                                            <a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" target="_self" title="{{ $product->name }}">
                                                                <img src="{{ $product->images->first()->getUrl('card') }}" alt="{{ $product->name }}" class="img-responsive">
                                                            </a>
                                                            <div class="button-group so-quickview">
                                                                @php
                                                                    $product_id = $product->id;
                                                                @endphp
                                                                @include('user.components.productButtons')
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item-right col-lg-6 col-md-7 col-sm-7 col-xs-12">
                                                        <div class="caption">
                                                            <h4><a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" target="_self" title="{{ $product->name }}">{{ $product->name }}</a></h4>
                                                            <p class="price">
                                                                @php
                                                                    $activeDiscount = $product->activeDiscount;
                                                                    $price = $product->price;
                                                                @endphp
                                                                @include('user.components.pricing')
                                                            </p>
                                                            <h3>
                                                                @if ($product->allow_points)
                                                                    <span class="label" style="background-color: #e4c90c;"><i class="fa fa-trophy"></i> {{ __('Get') }} {{ $product->final_price * \App\Models\GeneralSetting::pointsValue()->first()->value }} {{ __('Sa7tot') }}</span>
                                                                @endif
                                                            </h3>
                                                            
                                                            <h3>
                                                                @if ($product->free_shipping)
                                                                    <span class="label label-primary"><i class="fa fa-truck"></i> {{ __('Free shipping') }}</span>
                                                                @endif
                                                            </h3>
                                                            <p class="desc">{!! $product->short_description !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Deals -->

                <!-- Listing tabs custom -->
                <div class="module listingtab1-custom listingtab-layout1">
                    <h3 class="modtitle"><span>{{ __('New items') }}</span></h3>
                    <div id="so_listing_tabs_2" class="so-listing-tabs first-load">
                        <div class="loadeding"></div>
                        <div class="ltabs-wrap">
                            <div class="ltabs-tabs-container" data-delay="300" data-duration="600" data-effect="starwars" data-ajaxurl="" data-type_source="0" data-lg="1" data-md="1" data-sm="1" data-xs="1" data-margin="0">
                                <!--Begin Tabs-->                            
                                <div class="ltabs-tabs-wrap">   
                                    <span class='ltabs-tab-selected'></span>
                                    <span class="ltabs-tab-arrow">▼</span>
                                    <ul class="ltabs-tabs cf list-sub-cat font-title">   
                                        @foreach ($categories_with_latest_products as $cat)
                                            <li class="ltabs-tab @if ($loop->index == 0)
                                                tab-sel
                                            @endif" data-category-id="{{ $cat->id }}" data-active-content=".items-category-{{ $cat->id }}"><span class="ltabs-tab-label">{{ $cat->name }}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- End Tabs-->
                            </div>
                            <div class="ltabs-items-container products-list grid">

                                @foreach ($categories_with_latest_products as $cat)
                                    <!--Begin Items-->
                                    <div class="ltabs-items @if ($loop->index == 0)
                                        ltabs-items-selected
                                    @endif items-category-{{ $cat->id }}" data-total="14">
                                        <div class="ltabs-items-inner ltabs-slider">
                                            <!-- item listing tab -->
                                            <div class="ltabs-item">
                                                @foreach ($cat->latestProducts as $product)
                                                    @if ($loop->index == 0)
                                                        <div class="item-inner product-layout transition product-grid first-item">
                                                            <div class="product-item-container">
                                                                <div class="left-block">
                                                                    <div class="product-image-container second_img" style="height: 400px;">
                                                                        <a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" target="_self" title="{{ $product->name }}">
                                                                            <img src="{{ $product->images->first()->getUrl() }}" class="img-1 img-responsive" alt="{{ $product->name }}">
                                                                            @if (count($product->images) > 1)
                                                                                <img src="{{ $product->images[1]->getUrl() }}" class="img-2 img-responsive" alt="{{ $product->name }}">
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    
                                                                    <div class="button-group so-quickview cartinfo--left">
                                                                        @php
                                                                            $product_id = $product->id;
                                                                        @endphp
                                                                        @include('user.components.productButtons')
                                                                    </div>
                                                                    @if ($product->activeDiscount)
                                                                        <div class="box-label"> <span class="label-product label-sale"> -{{ $product->discount_percentage }}% </span></div>
                                                                    @endif
                                                                </div>
                                                                <div class="right-block">
                                                                    <div class="caption">
                                                                        <div class="price">
                                                                            @php
                                                                                $activeDiscount = $product->activeDiscount;
                                                                                $price = $product->price;
                                                                            @endphp
                                                                            @include('user.components.pricing')
                                                                        </div>
                                                                        <h4><a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" title="{{ $product->name }}" target="_self">{{ $product->name }}</a></h4>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="item-inner product-layout transition product-grid">
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
                                                                        <div class="price">
                                                                            @php
                                                                                $activeDiscount = $product->activeDiscount;
                                                                                $price = $product->price;
                                                                            @endphp
                                                                            @include('user.components.pricing')
                                                                        </div>
                                                                        <h4><a href="{{ route('user.products.show', ['product'=> $product->id, 'slug' => $product->slug]) }}" title="{{ $product->name }}" target="_self">{{ $product->name }}</a></h4>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <!-- end item listing tab -->
                                        </div>
                                        
                                    </div>
                                @endforeach
                            
                                <!--End Items-->
                            </div>

                        </div>

                    </div>
                </div>
                <!-- end Listing tabs custom -->

                <!-- Listing tabs custom -->
                <div class="module listingtab1-custom listingtab-layout1">
                    <h3 class="modtitle"><span>{{ __('Latest items') }}</span></h3>
                    <div class="row">
                        <div class="products-list grid row nopadding-xs so-filter-gird" style="margin-bottom: 4rem">
                
                            @foreach ($all_products as $product)
                                <div class="product-layout col-lg-15 col-md-4 col-sm-6 col-xs-12" style="height: 324px">
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
                                                    @php
                                                        $activeDiscount = $product->activeDiscount;
                                                        $price = $product->price;
                                                    @endphp
                                                    @include('user.components.pricing')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                        {{ $all_products->links() }}
                    </div>
                </div>
                            
            </div>
            <div class="slider-brands col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="yt-content-slider contentslider" data-autoplay="no" data-delay="4" data-speed="0.6" data-margin="0" data-items_column0="8" data-items_column1="6" data-items_column2="3" data-items_column3="2" data-items_column4="1" data-arrows="yes"
                        data-pagination="no" data-lazyload="yes" data-loop="no">
                    @foreach ($home_brands as $brand)
                        <div class="item">
                            <a href="{{ route('user.products.brand.show', $brand->id) }}">
                                <img src="{{ $brand->image->getUrl('thumb') }}" alt="{{ $brand->name }}">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- //Main Container -->
@endsection