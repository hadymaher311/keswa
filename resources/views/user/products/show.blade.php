@extends('user.layouts.app')

@section('title')
    {{ $product->name }} - {{ config('app.name') }}
@endsection

@section('css')
<link href="{{ asset('/user_styles/js/lightslider/lightslider.css') }}" rel="stylesheet">
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem;">
    
    <div class="row">

        <!--Left Part Start -->
        <aside class="col-sm-4 col-md-3 content-aside" id="column-left">
            
            @include('user.components.categories')
            
            @include('user.components.latestProducts')
            
        </aside>
        <!--Left Part End -->

        <!--Middle Part Start-->
        <div id="content" class="col-md-9 col-sm-8">
            
            <div class="product-view row">
                <div class="left-content-product">
            
                    <div class="content-product-left col-md-6 col-sm-12 col-xs-12">
                        <div id="thumb-slider-vertical" class="thumb-vertical-outer">
                            <ul class="thumb-vertical">

                                <div class="owl2-item" id="thumb-slider" class="yt-content-slider full_slider owl-drag" data-rtl="yes" data-autoplay="no" data-autoheight="no" data-delay="4" data-speed="0.6" data-margin="10" data-items_column0="4" data-items_column1="3" data-items_column2="4"  data-items_column3="1" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-loop="no" data-hoverpause="yes">
                                    @foreach ($product->images as $image)
                                            <a data-index="{{ $loop->index }}" class="img thumbnail" data-image="{{ $image->getUrl() }}" title="{{ $product->name }}">
                                                <img src="{{ $image->getUrl() }}" title="{{ $product->name }}" alt="{{ $product->name }}">
                                            </a>
                                    @endforeach
                                </div>
                            </ul>
                            
                            
                        </div>
                        <div class="large-image text-center vertical">
                            <img itemprop="image" class="product-image-zoom" src="{{ $product->images->first()->getUrl() }}" data-zoom-image="{{ $product->images->first()->getUrl() }}" title="{{ $product->name }}" alt="{{ $product->name }}">
                        </div>
                        
                    </div>

                    <div class="content-product-right col-md-6 col-sm-12 col-xs-12">
                        <div class="title-product">
                            <h1>{{ $product->name }}</h1>
                        </div>
                        <!-- Review ---->
                        <div class="box-review form-group">
                            <div class="ratings">
                                <div class="rating-box">
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
                            </div>

                            <a class="reviews_button" href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">{{ $product->approvedReviews()->count() }} {{ __('reviews') }}</a>	| 
                            <a class="write_review_button" href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;">{{ __('Write a review') }}</a>
                        </div>

                        <div class="product-label form-group">
                            <div class="product_page_price price">
                                @php
                                    $activeDiscount = $product->activeDiscount;
                                    $price = $product->price;
                                @endphp
                                @include('user.components.pricing')
                            </div>
                            <div class="stock"><span>{{ __('Availability') }}:</span> 
                                @if ($product->isAvailable())
                                    <span class="status-stock">{{ __('In Stock') }}</span>
                                @else
                                    <span class="status-stock">{{ __('Out of Stock') }}</span>
                                @endif
                            </div>
                        </div>

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

                        <div class="product-box-desc">
                            <div class="inner-box-desc">
                                @if ($product->activeDiscount)
                                    <div class="price-tax"><span>{{ __('Save:') }} </span> {{ $product->discount_percentage }} %</div>
                                @endif
                                <div class="brand"><span>{{ __('Brand') }}: </span><a href="{{ route('user.products.brand.show', $product->brand->id) }}">{{ $product->brand->name }}</a>		</div>
                                <div class="model"><span>{{ __('Summary') }}: </span> {!! $product->short_description !!}</div>
                            </div>
                        </div>


                        <div id="product">
                            @if ($product->features)
                                <h4>{{ __('Features') }}</h4>
                                @foreach ($product->features as $feature)
                                    <div><b>{{ $feature->name }}: </b> {{ $feature->value }}</div>
                                @endforeach
                            @endif

                            <div class="form-group box-info-product">
                                <form action="{{ route('user.cart.store', $product->id) }}" method="post">
                                    @csrf
                                    <div class="option quantity">
                                        <div class="input-group quantity-control" unselectable="on" style="-webkit-user-select: none;">
                                            <label>{{ __('Quantity') }}</label>
                                            <input class="form-control" type="text" name="quantity"
                                            value="1">
                                            <span class="input-group-addon product_quantity_down">−</span>
                                            <span class="input-group-addon product_quantity_up">+</span>
                                        </div>
                                    </div>
                                    <div class="cart">
                                        <input type="submit" data-toggle="tooltip" title="" value="{{ __('Add to cart') }}" data-loading-text="Loading..." id="button-cart" class="btn btn-mega btn-lg" data-original-title="{{ __('Add to cart') }}">
                                    </div>
                                </form>
                                <div class="add-to-links wish_comp">
                                    <ul class="blank list-inline">
                                        <li class="wishlist">
                                            <form action="{{ route('user.wishlist.store', $product->id) }}" method="post">
                                                @csrf
                                                <a class="icon" data-toggle="tooltip" title="" onclick="$(this).parent('form').submit()" data-original-title="{{ __('Add to WishList') }}"><i class="fa fa-heart"></i></a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                        <!-- end box info product -->

                    </div>
            
                </div>
            </div>
            <!-- Product Tabs -->
            <div class="producttab ">
                <div class="tabsslider  vertical-tabs col-xs-12">
                    <ul class="nav nav-tabs col-lg-2 col-sm-3">
                        <li class="active"><a data-toggle="tab" href="#tab-1">{{ __('Description') }}</a></li>
                        <li class="item_nonactive"><a data-toggle="tab" href="#tab-review">{{ __('Reviews') }} ({{ $product->approvedReviews->count() }})</a></li>
                        <li class="item_nonactive"><a data-toggle="tab" href="#tab-4">{{ __('Tags') }}</a></li>
                    </ul>
                    <div class="tab-content col-lg-10 col-sm-9 col-xs-12">
                        <div id="tab-1" class="tab-pane fade active in">
                            {!! $product->description !!}
                        </div>
                        <div id="tab-review" class="tab-pane fade">
                            <div id="review">
                                <table class="table table-striped table-bordered">
                                    <tbody>
                                        @foreach ($product->approvedReviews as $review)
                                            <tr>
                                                <td style="width: 50%;"><strong>{{ $review->author->name }}</strong></td>
                                                <td class="text-right">{{ $review->created_at->format('Y/m/d') }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p>{!! $review->content !!}</p>
                                                    <div class="ratings">
                                                        <div class="rating-box">
                                                            @php $rating = $review->rate; @endphp  

                                                            @include('user.components.rating')
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="text-right"></div>
                            </div>

                            @auth
                                <h2 id="review-title">{{ __('Write a review') }}</h2>
                                <form action="{{ route('user.review.store', $product->id) }}" method="post">
                                    @csrf
                                    <div class="contacts-form">
                                        <div class="form-group"> <span class="icon icon-bubbles-2"></span>
                                            <textarea class="form-control @error('content') is-invalid @enderror" placeholder="{{ __('Your Review') }}" name="content" required>{{ old('content') }}</textarea>
                                            @error('content')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> 
                                        <div class="form-group">
                                            <b>{{ __('Rating') }}</b> <span>{{ __('Bad') }}</span>&nbsp;
                                            <input type="radio" required name="rate" value="1"> &nbsp;
                                            <input type="radio" required name="rate"
                                            value="2"> &nbsp;
                                            <input type="radio" required name="rate"
                                            value="3"> &nbsp;
                                            <input type="radio" required name="rate"
                                            value="4"> &nbsp;
                                            <input type="radio" required name="rate"
                                            value="5"> &nbsp;<span>{{ __('Good') }}</span>
                                            @error('rating')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        
                                        </div>
                                        <div class="buttons clearfix"><button type="submit" class="btn buttonGray">{{ __('Continue') }}</button></div>
                                    </div>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login to add review') }}</a>
                            @endauth
                        </div>
                        <div id="tab-4" class="tab-pane fade">
                            @foreach ($product->tags as $tag)
                                <a class="label label-primary" href="#">{{ $tag->name }}</a>,
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- //Product Tabs -->

            @if ($product->active_related_products->count())
                <!-- Related Products -->
                <div class="related titleLine products-list grid module ">
                    <h3 class="modtitle">{{ __('Related products') }}  </h3>
            
                    <div class="releate-products yt-content-slider products-list" data-rtl="yes" data-loop="yes" data-autoplay="no" data-autoheight="no" data-autowidth="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column0="5" data-items_column1="3" data-items_column2="3" data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-hoverpause="yes">
                        @foreach ($product->active_related_products as $related)
                            <div class="item">
                                <div class="item-inner product-layout transition product-grid">
                                    <div class="product-item-container">
                                        <div class="left-block">
                                            <div class="product-image-container second_img">
                                                <a href="{{ route('user.products.show', ['product'=> $related->id, 'slug' => $related->slug]) }}" target="_self" title="{{ $related->name }}">
                                                    <img src="{{ $related->images->first()->getUrl('card') }}" class="img-1 img-responsive" alt="{{ $related->name }}">
                                                    @if (count($related->images) > 1)
                                                        <img src="{{ $related->images[1]->getUrl('card') }}" class="img-2 img-responsive" alt="{{ $related->name }}">
                                                    @endif
                                                </a>
                                            </div>
                                            @if ($related->activeDiscount)
                                                <div class="box-label"> <span class="label-product label-sale"> -{{ $related->discount_percentage }}% </span></div>
                                            @endif
                                            <div class="button-group so-quickview cartinfo--left">
                                                @php
                                                    $product_id = $related->id;
                                                @endphp
                                                @include('user.components.productButtons')
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <div class="caption">
                                                <div class="rating">
                                                    @php $rating = $related->rating; @endphp  

                                                    @include('user.components.rating')
                                                </div>
                                                <div class="price">
                                                    @php
                                                        $activeDiscount = $related->activeDiscount;
                                                        $price = $related->price;
                                                    @endphp
                                                    @include('user.components.pricing')
                                                </div>
                                                <h4><a href="{{ route('user.products.show', ['product'=> $related->id, 'slug' => $related->slug]) }}" title="{{ $related->name }}" target="_self">{{ $related->name }}</a></h4>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                <!-- end Related  Products-->
                </div>
            @endif

            @if ($product->active_accessories->count())
                <!-- Accessories -->
                <div class="related titleLine products-list grid module ">
                    <h3 class="modtitle">{{ __('Accessories') }}  </h3>
            
                    <div class="releate-products yt-content-slider products-list" data-rtl="yes" data-loop="yes" data-autoplay="no" data-autoheight="no" data-autowidth="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column0="5" data-items_column1="3" data-items_column2="3" data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-hoverpause="yes">
                        @foreach ($product->active_accessories as $accessory)
                            <div class="item">
                                <div class="item-inner product-layout transition product-grid">
                                    <div class="product-item-container">
                                        <div class="left-block">
                                            <div class="product-image-container second_img">
                                                <a href="{{ route('user.products.show', ['product'=> $accessory->id, 'slug' => $accessory->slug]) }}" target="_self" title="{{ $accessory->name }}">
                                                    <img src="{{ $accessory->images->first()->getUrl('card') }}" class="img-1 img-responsive" alt="{{ $accessory->name }}">
                                                    @if (count($accessory->images) > 1)
                                                        <img src="{{ $accessory->images[1]->getUrl('card') }}" class="img-2 img-responsive" alt="{{ $accessory->name }}">
                                                    @endif
                                                </a>
                                            </div>
                                            @if ($accessory->activeDiscount)
                                                <div class="box-label"> <span class="label-product label-sale"> -{{ $accessory->discount_percentage }}% </span></div>
                                            @endif
                                            <div class="button-group so-quickview cartinfo--left">
                                                @php
                                                    $product_id = $accessory->id;
                                                @endphp
                                                @include('user.components.productButtons')
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <div class="caption">
                                                <div class="rating">
                                                    @php $rating = $accessory->rating; @endphp  

                                                    @include('user.components.rating')
                                                </div>
                                                <div class="price">
                                                    @php
                                                        $activeDiscount = $accessory->activeDiscount;
                                                        $price = $accessory->price;
                                                    @endphp
                                                    @include('user.components.pricing')
                                                </div>
                                                <h4><a href="{{ route('user.products.show', ['product'=> $accessory->id, 'slug' => $accessory->slug]) }}" title="{{ $accessory->name }}" target="_self">{{ $accessory->name }}</a></h4>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                <!-- end Accessories-->
                </div>    
            @endif
        </div>
        
        
    </div>
    <!--Middle Part End-->
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/user_styles/js/lightslider/lightslider.js') }}"></script>
<script>
    $(function() {
        @if (count($errors->all()))
            @if (app()->getLocale() == 'ar')
                iziToast.error({
                    title: '{{ __("Whooops") }}!',
                    message: '{{ __("Something worng happened") }}',
                    position: 'topRight'
                });
            @else
                iziToast.error({
                    title: '{{ __("Whooops") }}!',
                    message: '{{ __("Something worng happened") }}',
                    position: 'topLeft'
                });
            @endif
        @endif
    })
</script>
@endsection
