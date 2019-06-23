@extends('user.layouts.app')

@section('title')
    {{ $product->name }} - {{ config('app.name') }}
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

                                @foreach ($product->images as $image)
                                    <li class="owl2-item">
                                        <a data-index="{{ $loop->index }}" class="img thumbnail" data-image="{{ $image->getUrl() }}" title="Canon EOS 5D">
                                            <img src="{{ $image->getUrl() }}" title="{{ $product->name }}" alt="{{ $product->name }}">
                                        </a>
                                    </li>
                                @endforeach
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
                            <div class="stock"><span>{{ __('Availability') }}:</span> 
                                @if ($product->isAvailable())
                                    <span class="status-stock">{{ __('In Stock') }}</span>
                                @else
                                    <span class="status-stock">{{ __('Out of Stock') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="product-box-desc">
                            <div class="inner-box-desc">
                                @if ($product->activeDiscount)
                                    <div class="price-tax"><span>{{ __('Save:') }} </span> {{ $product->discount_percentage }} %</div>
                                @endif
                                <div class="brand"><span>{{ __('Brand') }}: </span><a href="#">{{ $product->brand->name }}</a>		</div>
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
                                <div class="option quantity">
                                    <div class="input-group quantity-control" unselectable="on" style="-webkit-user-select: none;">
                                        <label>{{ __('Quantity') }}</label>
                                        <input class="form-control" type="text" name="quantity"
                                        value="1">
                                        <input type="hidden" name="product_id" value="">
                                        <span class="input-group-addon product_quantity_down">−</span>
                                        <span class="input-group-addon product_quantity_up">+</span>
                                    </div>
                                </div>
                                <div class="cart">
                                    <input type="button" data-toggle="tooltip" title="" value="{{ __('Add to cart') }}" data-loading-text="Loading..." id="button-cart" class="btn btn-mega btn-lg" data-original-title="{{ __('Add to cart') }}">
                                </div>
                                <div class="add-to-links wish_comp">
                                    <ul class="blank list-inline">
                                        <li class="wishlist">
                                            <a class="icon" data-toggle="tooltip" title=""
                                            data-original-title="{{ __('Add to WishList') }}"><i class="fa fa-heart"></i>
                                            </a>
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
                            <form>
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
                                    <div class="contacts-form">
                                        <div class="form-group"> <span class="icon icon-user"></span>
                                            <input type="text" name="name" class="form-control" value="Your Name" onblur="if (this.value == '') {this.value = 'Your Name';}" onfocus="if(this.value == 'Your Name') {this.value = '';}"> 
                                        </div>
                                        <div class="form-group"> <span class="icon icon-bubbles-2"></span>
                                            <textarea class="form-control" name="text" onblur="if (this.value == '') {this.value = 'Your Review';}" onfocus="if(this.value == 'Your Review') {this.value = '';}">Your Review</textarea>
                                        </div> 
                                        <span style="font-size: 11px;"><span class="text-danger">Note:</span>						HTML is not translated!</span>
                                        
                                        <div class="form-group">
                                            <b>Rating</b> <span>Bad</span>&nbsp;
                                        <input type="radio" name="rating" value="1"> &nbsp;
                                        <input type="radio" name="rating"
                                        value="2"> &nbsp;
                                        <input type="radio" name="rating"
                                        value="3"> &nbsp;
                                        <input type="radio" name="rating"
                                        value="4"> &nbsp;
                                        <input type="radio" name="rating"
                                        value="5"> &nbsp;<span>Good</span>
                                        
                                        </div>
                                        <div class="buttons clearfix"><a id="button-review" class="btn buttonGray">Continue</a></div>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Login to add review') }}</a>
                                @endauth
                            </form>
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

            @if ($product->related_products->count())
                <!-- Related Products -->
                <div class="related titleLine products-list grid module ">
                    <h3 class="modtitle">{{ __('Related products') }}  </h3>
            
                    <div class="releate-products yt-content-slider products-list" data-rtl="yes" data-loop="yes" data-autoplay="no" data-autoheight="no" data-autowidth="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column0="5" data-items_column1="3" data-items_column2="3" data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-hoverpause="yes">
                        @foreach ($product->related_products as $related)
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
                                                @if ($related->activeDiscount->type == 'value')
                                                    <div class="box-label"> <span class="label-product label-sale"> -{{ (1 - ($related->price / $related->activeDiscount->amount)) *100 }}% </span></div>
                                                @else
                                                    <div class="box-label"> <span class="label-product label-sale"> -{{ $related->activeDiscount->amount }}% </span></div>
                                                @endif
                                            @endif
                                            <div class="button-group so-quickview cartinfo--left">
                                                <button type="button" class="addToCart btn-button" title="{{ __('Add to cart') }}">  <i class="fa fa-shopping-basket"></i>
                                                    <span>{{ __('Add to cart') }} </span>   
                                                </button>
                                                <button type="button" class="wishlist btn-button" title="{{ __('Add to WishList') }}"><i class="fa fa-heart"></i><span>{{ __('Add to WishList') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <div class="caption">
                                                <div class="rating">
                                                    @php $rating = $related->rating; @endphp  

                                                    @include('user.components.rating')
                                                </div>
                                                <div class="price">
                                                    @if ($related->activeDiscount)
                                                        <span class="price-old">{{ $related->price }} {{ __('LE') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        @if ($related->activeDiscount->type == 'value')
                                                            <span class="price-new">{{ $related->price - $related->activeDiscount->amount }} {{ __('LE') }}</span>
                                                        @elseif ($related->activeDiscount->type == 'percentage')
                                                            <span class="price-new">{{ ($related->price * (100 - $related->activeDiscount->amount) / 100) }} {{ __('LE') }}</span>
                                                        @endif
                                                    @else
                                                        <span>{{ $related->price }} {{ __('LE') }}</span>
                                                    @endif
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

            @if ($product->accessories->count())
                <!-- Accessories -->
                <div class="related titleLine products-list grid module ">
                    <h3 class="modtitle">{{ __('Accessories') }}  </h3>
            
                    <div class="releate-products yt-content-slider products-list" data-rtl="yes" data-loop="yes" data-autoplay="no" data-autoheight="no" data-autowidth="no" data-delay="4" data-speed="0.6" data-margin="30" data-items_column0="5" data-items_column1="3" data-items_column2="3" data-items_column3="2" data-items_column4="1" data-arrows="yes" data-pagination="no" data-lazyload="yes" data-hoverpause="yes">
                        @foreach ($product->accessories as $accessory)
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
                                                @if ($accessory->activeDiscount->type == 'value')
                                                    <div class="box-label"> <span class="label-product label-sale"> -{{ (1 - ($accessory->price / $accessory->activeDiscount->amount)) *100 }}% </span></div>
                                                @else
                                                    <div class="box-label"> <span class="label-product label-sale"> -{{ $accessory->activeDiscount->amount }}% </span></div>
                                                @endif
                                            @endif
                                            <div class="button-group so-quickview cartinfo--left">
                                                <button type="button" class="addToCart btn-button" title="{{ __('Add to cart') }}">  <i class="fa fa-shopping-basket"></i>
                                                    <span>{{ __('Add to cart') }} </span>   
                                                </button>
                                                <button type="button" class="wishlist btn-button" title="{{ __('Add to WishList') }}"><i class="fa fa-heart"></i><span>{{ __('Add to WishList') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="right-block">
                                            <div class="caption">
                                                <div class="rating">
                                                    @php $rating = $accessory->rating; @endphp  

                                                    @include('user.components.rating')
                                                </div>
                                                <div class="price">
                                                    @if ($accessory->activeDiscount)
                                                        <span class="price-old">{{ $accessory->price }} {{ __('LE') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        @if ($accessory->activeDiscount->type == 'value')
                                                            <span class="price-new">{{ $accessory->price - $accessory->activeDiscount->amount }} {{ __('LE') }}</span>
                                                        @elseif ($accessory->activeDiscount->type == 'percentage')
                                                            <span class="price-new">{{ ($accessory->price * (100 - $accessory->activeDiscount->amount) / 100) }} {{ __('LE') }}</span>
                                                        @endif
                                                    @else
                                                        <span>{{ $accessory->price }} {{ __('LE') }}</span>
                                                    @endif
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
