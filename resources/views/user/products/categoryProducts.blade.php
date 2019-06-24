@extends('user.layouts.app')

@section('title')
    {{ $searched_category->name }} - {{ config('app.name') }}
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
                    <h3 class="title-category ">{{ $searched_category->name }}</h3>
                    <div class="category-derc">
                        <div class="row">
                            <div class="col-sm-12">
                                {!! $searched_category->description !!}
                            
                            </div>
                        </div>
                    </div>
                    <!-- Filters -->
                    <div class="product-filter product-filter-top filters-panel">
                        <div class="row">
                            <div class="col-md-5 col-sm-3 col-xs-12 view-mode">
                                
                                    <div class="list-view">
                                        <button class="btn btn-default grid active" data-view="grid" data-toggle="tooltip"  data-original-title="Grid"><i class="fa fa-th"></i></button>
                                        <button class="btn btn-default list" data-view="list" data-toggle="tooltip" data-original-title="List"><i class="fa fa-th-list"></i></button>
                                    </div>
                        
                            </div>
                            <div class="short-by-show form-inline text-right col-md-7 col-sm-9 col-xs-12">
                                <form action="{{ route('user.products.category.show', $searched_category->id) }}" method="get">
                                    <div class="form-group short-by">
                                        <label class="control-label" for="input-sort">{{ __('Sort By') }}:</label>
                                        <select id="input-sort" name="sort" class="form-control">
                                            <option value="created_at-desc">{{ __('Default') }}</option>
                                            <option value="name_{{ app()->getLocale() }}-asc">{{ __('Name') }} ({{ __('A - Z') }})</option>
                                            <option value="name_{{ app()->getLocale() }}-desc">{{ __('Name') }} ({{ __('Z - A') }})</option>
                                            <option value="price-asc">{{ __('Price') }} ({{ __('Low') }} &gt; {{ __('High') }})</option>
                                            <option value="price-desc">{{ __('Price') }} ({{ __('High') }} &gt; {{ __('Low') }})</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- //end Filters -->
                    <!--changed listings-->
                    <div class="products-list grid row nopadding-xs so-filter-gird">
                
                        @foreach ($category_products as $product)
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
                                            @if ($product->activeDiscount->type == 'value')
                                                <div class="box-label"> <span class="label-product label-sale"> -{{ (1 - ($product->price / $product->activeDiscount->amount)) *100 }}% </span></div>
                                            @else
                                                <div class="box-label"> <span class="label-product label-sale"> -{{ $product->activeDiscount->amount }}% </span></div>
                                            @endif
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
                    {{ $category_products->links() }}
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
