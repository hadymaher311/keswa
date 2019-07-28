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
                            {{ $return->user->name }}<br>
                            {{ $return->user->email }}<br>
                            {{ ($return->user->personalInfo) ? $return->user->personalInfo->phone : '' }}<br>
                            {{ ($return->user->personalInfo) ? __(ucfirst($return->user->personalInfo->gender)) : '' }}
                        </address>
                    </div>
                    @if ($return->address)
                        <div class="col-md-6 {{ app()->isLocale('ar') ? 'text-right' : '' }}">
                            <address>
                                <strong>{{ __('Address') }}:</strong><br>
                                <div>
                                    <b>{{ $return->address->country }}, {{ $return->address->city }}</b>
                                </div>
                                <div>
                                    <b>{{ __('Location') }}: </b>{{ __(ucfirst($return->address->location_type)) }}
                                </div>
                                <div>
                                    <b>{{ __('Street Name/No') }}: </b>{{ $return->address->street }}
                                </div>
                                <div>
                                    <b>{{ __('Building Name/No') }}: </b>{{ $return->address->building }}
                                </div>
                                <div>
                                    <b>{{ __('Floor No') }}: </b>{{ $return->address->floor }}
                                </div>
                                <div>
                                    <b>{{ __('Apartment No') }}: </b>{{ $return->address->apartment }}
                                </div>
                                <div>
                                    <b>{{ __('Nearest Landmark') }}: </b>{{ $return->address->nearest_landmark }}
                                </div>
                            </address>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6 {{ app()->isLocale('ar') ? 'text-right' : '' }}">
                        <address>
                        <strong>{{ __('Return ID') }}:</strong><br>
                        #{{ $return->id }}
                        <br>
                        <strong>{{ __('Order') }}:</strong><br>
                        #{{ $return->order->id }}
                        </address>
                    </div>
                    <div class="col-md-6 {{ app()->isLocale('ar') ? 'text-right' : '' }}">
                        <address>
                            @if ($return->delivery)
                                <strong>{{ __('Delivery man') }}:</strong><br>
                                {{ $return->delivery->name }}<br><br>
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
                    <th class="">{{ __('Product Name') }}</th>
                    <th class="text-center">{{ __('Quantity') }}</th>
                    <th class="text-center">{{ __('Unit Price') }}</th>
                    <th class="text-right">{{ __('Total Price') }}</th>
                </tr>
                <tr>
                    <td class="">{{ $return->product->name }}</td>
                    <td class="text-center">{{ $return->quantity }}</td>
                    <td class="text-center">
                        @php
                            $activeDiscount = $return->product->activeDiscount;
                            $price = $return->product->price;
                        @endphp
                        @include('admin.components.pricing')
                    </td>
                    <td class="text-right">{{ $return->quantity * $return->product->final_price }} {{ __('LE') }}</td>
                </tr>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>