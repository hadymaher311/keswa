<div class="invoice">
    <div class="invoice-print" id="invoice-print">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-title">
                    <h2>{{ config('app.name') }}</h2>
                    <div style="font-weight: 700;">{{ __('Date') }}: {{ now()->format('d/m/Y') }}</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 {{ app()->isLocale('ar') ? 'text-right' : '' }}">
                        <address>
                            <strong>{{ __('Billed To') }}:</strong><br>
                            {{ $order->user->name }}<br>
                            {{ $order->user->email }}<br>
                            {{ ($order->user->personalInfo) ? $order->user->personalInfo->phone : '' }}<br>
                            {{ ($order->user->personalInfo) ? __(ucfirst($order->user->personalInfo->gender)) : '' }}
                        </address>
                    </div>
                    @if ($order->address)
                        <div class="col-md-6 {{ app()->isLocale('ar') ? 'text-right' : '' }}">
                            <address>
                                <strong>{{ __('Address') }}:</strong><br>
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
                            </address>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6 {{ app()->isLocale('ar') ? 'text-right' : '' }}">
                        <address>
                        <strong>{{ __('Order ID') }}:</strong><br>
                        #{{ $order->id }}
                        <br>
                        <strong>{{ __('Payment Method') }}:</strong><br>
                        @if ($order->payment_method == 'COD')
                            {{ __('Cash On Delivery') }}                            
                        @endif
                        </address>
                    </div>
                    <div class="col-md-6 {{ app()->isLocale('ar') ? 'text-right' : '' }}">
                        <address>
                            <strong>{{ __('Order Date') }}:</strong><br>
                            {{ $order->created_at }}<br><br>
                            @if ($order->delivery)
                                <strong>{{ __('Delivery man') }}:</strong><br>
                                {{ $order->delivery->name }}<br><br>
                            @endif
                        </address>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
        <div class="col-md-12">
            <h5 class="{{ app()->isLocale('ar') ? 'text-right' : '' }}">{{ __('Products') }}</h5>
            <div class="table-responsive">
            <table class="table table-striped table-hover table-md">
                <tr>
                    <th data-width="40">#</th>
                    <th class="">{{ __('Product Name') }}</th>
                    <th class="text-center">{{ __('Quantity') }}</th>
                    <th class="text-center">{{ __('Unit Price') }}</th>
                    <th class="text-right">{{ __('Total Price') }}</th>
                </tr>
                <tr>
                    @foreach ($order->products as $product)
                        <tr>
                            <td>{{ $loop->index }}</td>
                            <td class="">{{ $product->name }}</td>
                            <td class="text-center">{{ $product->pivot->quantity }}</td>
                            <td class="text-center">
                                @php
                                    $activeDiscount = $product->activeDiscount;
                                    $price = $product->price;
                                @endphp
                                @include('admin.components.pricing')
                            </td>
                            <td class="text-right">{{ $product->pivot->quantity * $product->final_price }} {{ __('LE') }}</td>
                        </tr>
                    @endforeach
                </tr>
            </table>
            </div>
            <div class="row mt-4">
                <div class="col-lg-4 {{ app()->isLocale('ar') ? 'text-right' : '' }}">
                    <div class="invoice-detail-item">
                    <div class="invoice-detail-name">{{ __('Sub-Total Price') }}</div>
                    <div class="invoice-detail-value">{{ ceil($order->total_price) }} {{ __('LE') }}</div>
                    </div>
                    <div class="invoice-detail-item">
                    <div class="invoice-detail-name">{{ __('Price Tax') }} ({{ $price_tax->value }}%)</div>
                    <div class="invoice-detail-value">{{ ceil($order->total_price * ($price_tax->value / 100)) }} {{ __('LE') }}</div>
                    </div>
                    <div class="invoice-detail-item">
                    <div class="invoice-detail-name">{{ __('Shipping price') }}</div>
                    <div class="invoice-detail-value">{{ ceil($order->shipping_price) }} {{ __('LE') }}</div>
                    </div>
                    <hr class="mt-2 mb-2">
                    <div class="invoice-detail-item">
                    <div class="invoice-detail-name">{{ __('Total Price') }}</div>
                    <div class="invoice-detail-value invoice-detail-value-lg">{{ ceil($order->total_price + $order->shipping_price + ceil($order->total_price * ($price_tax->value / 100))) }} {{ __('LE') }}</div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>