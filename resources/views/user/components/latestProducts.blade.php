<div class="module product-simple hidden-sm hidden-xs">
    <h3 class="modtitle">
        <span>{{ __('Latest products') }}</span>
    </h3>
    <div class="modcontent">
        <div class="extraslider" >
            <!-- Begin extraslider-inner -->
            <div class=" extraslider-inner">
                <div class="item ">

                    @foreach ($latest_products as $pro)
                        <div class="product-layout item-inner style1 ">
                            <div class="item-image">
                                <div class="item-img-info">
                                    <a href="{{ route('user.products.show', ['product'=> $pro->id, 'slug' => $pro->slug]) }}" target="_self" title="{{ $pro->name }} ">
                                        <img src="{{ $pro->images->first()->getUrl('card') }}" alt="{{ $pro->name }}">
                                        </a>
                                </div>
                                
                            </div>
                            <div class="item-info">
                                <div class="item-title">
                                    <a href="{{ route('user.products.show', ['product'=> $pro->id, 'slug' => $pro->slug]) }}" target="_self" title="{{ $pro->name }}">{{ $pro->name }} </a>
                                </div>
                                <div class="rating">
                                    @php $rating = $pro->rating; @endphp  

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
                                    @if ($pro->activeDiscount)
                                        <span class="price-old">{{ $pro->price }} {{ __('LE') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        @if ($pro->activeDiscount->type == 'value')
                                            <span class="price-new">{{ $pro->price - $pro->activeDiscount->amount }} {{ __('LE') }}</span>
                                        @elseif ($pro->activeDiscount->type == 'percentage')
                                            <span class="price-new">{{ ($pro->price * (100 - $pro->activeDiscount->amount) / 100) }} {{ __('LE') }}</span>
                                        @endif
                                    @else
                                        <span>{{ $pro->price }} {{ __('LE') }}</span>
                                    @endif
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