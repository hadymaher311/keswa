@extends('user.layouts.app')

@section('title')
    {{ __('Orders') }} - {{ config('app.name') }}
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">
    
    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-9">
            <h2 class="title">{{ __('Order Information') }}</h2>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td colspan="2" class="text-left">{{ __('Order Details') }}</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%;" class="text-left"> <b>{{ __('Order ID') }}:</b> #{{ $order->id }}
                            <br>
                            <b>{{ __('Date Added') }}:</b> {{ $order->created_at }}</td>
                        <td style="width: 50%;" class="text-left"> <b>{{ __('Payment Method') }}:</b> @if ($order->payment_method == 'COD')
                            {{ __('Cash On Delivery') }}                            
                        @endif
                            <br>
                            @if ($order->comment)
                                <b>{{ __('Comment') }}:</b> {!! $order->comment !!} </td>
                            @endif
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td style="width: 50%; vertical-align: top;" class="text-left">{{ __('Address') }}</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left">
                                <div>
                                    <b>{{ $order->address->country }}, {{ $order->address->city }}</b>
                                </div>
                                <div>
                                    <b>{{ __('Location') }}: </b>{{ __(ucfirst($order->address->location_type)) }}
                                </div>
                                <div>
                                    <b>{{ __('Street Name/No') }}: </b>{{ $order->address->street }}
                                </div>
                                <div>
                                    <b>{{ __('Building Name/No') }}: </b>{{ $order->address->building }}
                                </div>
                                <div>
                                    <b>{{ __('Floor No') }}: </b>{{ $order->address->floor }}
                                </div>
                                <div>
                                    <b>{{ __('Apartment No') }}: </b>{{ $order->address->apartment }}
                                </div>
                                <div>
                                    <b>{{ __('Nearest Landmark') }}: </b>{{ $order->address->nearest_landmark }}
                                </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-center">{{ __('Image') }}</td>
                            <td class="">{{ __('Product Name') }}</td>
                            <td class="">{{ __('Quantity') }}</td>
                            <td class="">{{ __('Unit Price') }}</td>
                            <td class="">{{ __('Total Price') }}</td>
                            <td style="width: 20px;"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td class="text-center"><a href="{{ route('user.products.show', [$product->id, $product->slug]) }}"><img width="70px" src="{{ $product->images->first()->getUrl('thumb') }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-thumbnail" /></a></td>
                                <td class=""><a href="{{ route('user.products.show', [$product->id, $product->slug]) }}">{{ $product->name }}</a><br />
                                    </td>
                                <td class="" width="200px">{{ $product->pivot->quantity }}</td>
                                <td class="price">
                                    @php
                                        $activeDiscount = $product->activeDiscount;
                                        $price = $product->price;
                                    @endphp
                                    @include('user.components.pricing')
                                </td>
                                <td class="">{{ $product->pivot->quantity * $product->final_price }} {{ __('LE') }}</td>
                                <td style="white-space: nowrap;" class="text-right">
                                    <a class="btn btn-danger" title="" data-toggle="tooltip" href="return.html" data-original-title="Return"><i class="fa fa-reply"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right">
                                <strong>{{ __('Sub-Total Price') }}:</strong>
                            </td>
                            <td class="text-right">{{ ceil($order->total_price) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <strong>{{ __('Price Tax') }} ({{ $price_tax->value }}%):</strong>
                            </td>
                            <td class="text-right">{{ ceil($order->total_price * ($price_tax->value / 100)) }}</td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <strong>{{ __('Total Price') }}:</strong>
                            </td>
                            <td class="text-right">{{ ceil($order->total_price + ceil($order->total_price * ($price_tax->value / 100))) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <h3>{{ __('Order History') }}</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td class="text-left">{{ __('Date Added') }}</td>
                        <td class="text-left">{{ __('Status') }}</td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $status_colors = [
                            'Waiting for confirmation' => 'primary',
                            'Approved' => 'primary',
                            'Shipped' => 'info',
                            'Completed' => 'success',
                            'Canceled' => 'danger',
                            'Pending' => 'warning',
                        ];
                    @endphp
                    @foreach ($order->statuses as $status)
                        <tr>
                            <td class="text-left">{{ $status->created_at }}</td>
                            <td class="text-left">
                                <div class="label label-{{ $status_colors[$status->name] }}">{{ __($status->name) }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>



        </div>

    @include('user.components.accountSideLinks')
    <!--Middle Part End -->
        
    </div>
</div>
<!-- //Main Container -->
@endsection