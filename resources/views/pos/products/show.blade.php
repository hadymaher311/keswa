@extends('pos.layouts.app')

@section('title')
{{ __('View product') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Products') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('View product') }}</h4> <br>
                    <a href="{{ route('pos_products.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible show fade">
                          <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                              <span>&times;</span>
                            </button>
                            {{ __(session('status')) }}
                          </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach ($product->images as $image)
                                        <li data-target="#carouselExampleIndicators3" data-slide-to="{{ $loop->index }}" class="@if ($loop->index == 0)
                                                active
                                            @endif"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach ($product->images as $image)
                                        <div class="carousel-item @if ($loop->index == 0)
                                            active
                                        @endif">
                                            <img class="d-block w-100" src="{{ $image->getUrl('card') }}" alt="First slide">
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h2>{{ $product->name }}</h2>
                            <div id="accordion">
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
                                        <h4>{{ __('Basic Info') }}</h4>
                                    </div>
                                    <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
                                        <h2>
                                            {{ $product->name }} 
                                            @if ($product->active)
                                                <div class="badge badge-success" style="padding: 7px 12px; font-size: 12px;">{{ __('Active') }}</div>
                                                @else
                                                <div class="badge badge-danger" style="padding: 7px 12px; font-size: 12px;">{{ __('Not Active') }}</div>
                                            @endif
                                        </h2>
                                        <div class="row">
                                            <div class="col-sm-3"><b>{{ __('Summary') }}:</b></div>
                                            <div class="col-sm-9">{!! $product->short_description !!}</div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3"><b>{{ __('UPC') }}:</b></div>
                                            <div class="col-9">{{ $product->upc }}</div>
                                            <div class="col-3"><b>{{ __('SKU') }}:</b></div>
                                            <div class="col-9">{{ $product->sku }}</div>
                                            <div class="col-3"><b>{{ __('Brand') }}:</b></div>
                                            <div class="col-9">{{ $product->brand->name }}</div>
                                            <div class="col-3"><b>{{ __('Categories') }}:</b></div>
                                            <div class="col-9">
                                                @foreach ($product->categories as $category)
                                                    <ol class="breadcrumb">
                                                        <li class="breadcrumb-item">{{ $category->sub_category->main_category->name }}</li>
                                                        <li class="breadcrumb-item">{{ $category->sub_category->name }}</li>
                                                        <li class="breadcrumb-item">{{ $category->name }}</li>
                                                    </ol>
                                                @endforeach
                                            </div>
                                            <div class="col-3"><b>{{ __('Cost') }}:</b></div>
                                            <div class="col-9">{{ $product->cost }} {{ __('LE') }}</div>
                                            <div class="col-3"><b>{{ __('Price') }}:</b></div>
                                            @if ($product->activeDiscount)
                                                <div class="col-9">
                                                    <span style="text-decoration: line-through">{{ $product->price }} {{ __('LE') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <span>{{ $product->final_price }} {{ __('LE') }}</span>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    @if ($product->final_price <= $product->cost)
                                                        <span class="text-danger">{{ __('No profit from this product') }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="col-9">
                                                    {{ $product->final_price }} {{ __('LE') }}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    @if ($product->final_price <= $product->cost)
                                                        <span class="text-danger">{{ __('No profit from this product') }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="col-3"><b>{{ __('Total price') }}:</b></div>
                                            <div class="col-9">
                                                {{ $product->price * $product->total_quantity }} {{ __('LE') }}
                                            </div>
                                            <div class="col-3"><b>{{ __('Available quantity') }}:</b></div>
                                            <div class="col-9">{{ $product->total_quantity }} {{ __(ucfirst($product->sale_by)) }}</div>
                                            <div class="col-3"><b>{{ __('Packets') }}:</b></div>
                                            <div class="col-9">{{ $product->total_quantity/$product->quantity_per_packet }} {{ __('Packet') }}</div>
                                            <div class="col-3"><b>{{ __('Expiry alert before') }}:</b></div>
                                            <div class="col-9">{{ $product->expiry_alarm_before }} {{ __('days') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-2">
                                        <h4>{{ __('Description') }}</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-2" data-parent="#accordion">
                                        <p class="mb-0">{!! $product->description !!}</p>
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-3">
                                        <h4>{{ __('Warehouses') }}</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-3" data-parent="#accordion">
                                        @forelse ($product->distinct_warehouses as $warehouse)
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-3"><b>{{ __('Name') }}:</b></div>
                                                        <div class="col-9">{{ $warehouse->name }}</div>
                                                        <div class="col-3"><b>{{ __('Location') }}:</b></div>
                                                        <div class="col-9">{{ $warehouse->location }}</div>
                                                        <div class="col-3"><b>{{ __('Quantity') }}:</b></div>
                                                        <div class="col-9">{{ $product->getWarehouseQuantity($warehouse->id) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-danger">{{ __('Not in warehouses yet') }}</div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-4">
                                        <h4>{{ __('Details') }}</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-4" data-parent="#accordion">
                                        <div class="row">
                                            <div class="col-3"><b>{{ __('Available quantity') }}:</b></div>
                                            <div class="col-9">{{ $product->total_quantity }} {{ __(ucfirst($product->sale_by)) }}</div>
                                            <div class="col-3"><b>{{ __('Low quantity') }}:</b></div>
                                            <div class="col-9">{{ $product->low_quantity }} {{ __(ucfirst($product->sale_by)) }}</div>
                                            <div class="col-3"><b>{{ __('Quantity per packet') }}:</b></div>
                                            <div class="col-9">{{ $product->quantity_per_packet }} {{ __(ucfirst($product->sale_by)) }}</div>
                                            <div class="col-3"><b>{{ __('Min sale quantity') }}:</b></div>
                                            <div class="col-9">{{ $product->min_sale_quantity }} {{ __(ucfirst($product->sale_by)) }}</div>
                                            <div class="col-3"><b>{{ __('Packets') }}:</b></div>
                                            <div class="col-9">{{ $product->total_quantity/$product->quantity_per_packet }} {{ __('Packet') }}</div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3"><b>{{ __('Shipping') }}:</b></div>
                                            <div class="col-9">
                                                @can('update products')
                                                    <form action="{{ route('pos_products.free.shipping', $product->id) }}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <label class="custom-switch mt-2" data-toggle="tooltip" data-placement="top" title="@if ($product->free_shipping)
                                                            {{ __('Free') }}
                                                            @else
                                                            {{ __('Not Free') }}
                                                            @endif">
                                                            <input name="active" value="{{ $product->id }}" type="checkbox" @if ($product->free_shipping)
                                                            checked
                                                            @endif class="custom-switch-input" onchange="
                                                                $(this).parent('form'),submit();
                                                            ">
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </form>
                                                @endcan
                                            </div>
                                            <div class="col-3"><b>{{ __('Weight') }}:</b></div>
                                            <div class="col-9">{{ $product->weight }} {{ __('Kg') }}</div>
                                            <div class="col-3"><b>{{ __('Dimensions') }}:</b></div>
                                            <div class="col-9">{{ $product->length }}*{{ $product->width }}*{{ $product->depth }} {{ __('cm') }}</div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3"><b>{{ __('Features') }}:</b></div>
                                            <div class="col-9">
                                                @foreach ($product->features as $feature)
                                                    <div>
                                                        <b>{{ $feature->name }}</b>&nbsp;&nbsp;&nbsp;&nbsp;{{ $feature->value }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3"><b>{{ __('Related products') }}:</b></div>
                                            <div class="col-9">
                                                <ul>
                                                    @foreach ($product->related_products as $related)
                                                        <li><a href="{{ route('pos_products.show', $related->id) }}">{{ $related->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3"><b>{{ __('Accessories') }}:</b></div>
                                            <div class="col-9">
                                                <ul>
                                                    @foreach ($product->accessories as $accessory)
                                                        <li><a href="{{ route('pos_products.show', $accessory->id) }}">{{ $accessory->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3"><b>{{ __('Tags') }}:</b></div>
                                            <div class="col-9">
                                                @foreach ($product->tags as $tag)
                                                    <span class="badge badge-primary">{{ $tag->name }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
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