
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
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible show fade">
          <div class="alert-body">
            <button class="close" data-dismiss="alert">
              <span>&times;</span>
            </button>
            {{ __(session('error')) }}
          </div>
        </div>
    @endif
    <h3>{{ __('Order ID') }}: #{{ $order->id }}</h3>
    <div class="row">
        <div class="col-sm-2"><b>{{ __('Payment Method') }}:</b></div>
        <div class="col-sm-10">
            @if ($order->payment_method == 'COD')
                {{ __('Cash On Delivery') }}                            
            @endif
        </div>
        @if ($order->comment)
            <div class="col-sm-2"><b>{{ __('Comment') }}:</b></div>
            <div class="col-sm-10">{!! $order->comment !!}</div>
        @endif
    </div>

    <br>
    <h4>{{ __('Status') }}</h4>
    <div class="wizard-steps">
        <div class="wizard-step wizard-step-warning">
            <div class="wizard-step-icon">
            <i class="fas fa-stopwatch"></i>
            </div>
            <div class="wizard-step-label">
            {{ __('Waiting for confirmation') }}
            </div>
        </div>
        @if ($order->isDisapproved())
            <div class="wizard-step wizard-step-danger">
                <div class="wizard-step-icon">
                    <i class="fas fa-times"></i>
                </div>
                <div class="wizard-step-label">
                    {{ __('Disapproved') }}
                </div>
            </div>
        @else
            <div class="wizard-step @if($order->isApproved())
                    wizard-step-active
                @else
                    wizard-step-default
                @endif">
                <div class="wizard-step-icon">
                    <i class="fas fa-info"></i>
                </div>
                <div class="wizard-step-label">
                    {{ __('Approved') }}
                </div>
            </div>
        @endif
        <div class="wizard-step @if($order->isShipped())
            wizard-step-info
        @else
            wizard-step-default
        @endif">
            <div class="wizard-step-icon">
                <i class="fas fa-shipping-fast"></i>
            </div>
            <div class="wizard-step-label">
                {{ __('Shipped') }}
            </div>
        </div>
        <div class="wizard-step @if($order->isCompleted())
            wizard-step-success
        @else
            wizard-step-default
        @endif">
            <div class="wizard-step-icon">
            <i class="fas fa-check"></i>
            </div>
            <div class="wizard-step-label">
            {{ __('Completed') }}
            </div>
        </div>
        @if ($order->isCanceled())
            <div class="wizard-step @if($order->isCanceled())
                wizard-step-danger
            @else
                wizard-step-default
            @endif">
                <div class="wizard-step-icon">
                    <i class="fas fa-times"></i>
                </div>
                <div class="wizard-step-label">
                    {{ __('Canceled') }}
                </div>
            </div>
        @endif
    </div>

    <br>
    <h4>{{ __('Order History') }}</h4>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td>{{ __('Date Added') }}</td>
                <td>{{ __('Status') }}</td>
                <td>{{ __('Comment') }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->statuses as $status)
                <tr>
                    <td>{{ $status->created_at }}</td>
                    <td>
                        @php
                            $order_status = $status->name;
                        @endphp
                        @include('admin.components.orderStatusColor')
                    </td>
                    <td>{!! $status->description !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <h4>{{ __('User') }}</h4>
    <div class="row">
        <div class="col-sm-2">
            <a href="{{ route('users.show', $order->user->id) }}"><img src="{{ ($order->user->image) ? $order->user->image->getUrl('card') : asset(config('default_avatar')) }}" alt="{{ $order->user->name }}" class="img-fluid img-circle img-thumbnail"></a>
        </div>
        <div class="col-sm-10">
            <h5><a href="{{ route('users.show', $order->user->id) }}">{{ $order->user->name }}</a></h5>
            <div><a href="mailto://{{ $order->user->email }}">{{ $order->user->email }}</a></div>
            <div>{{ ($order->user->personalInfo) ? $order->user->personalInfo->phone : '' }}</div>
            <div>{{ ($order->user->personalInfo) ? __(ucfirst($order->user->personalInfo->gender)) : '' }}</div>
        </div>
    </div>

    @if ($order->address)
        <br>
        <h4>{{ __('Address') }}</h4>
        <b>{{ __($order->address->country) }}, {{ __($order->address->city) }}</b>
        <div class="row">
            <div class="col-sm-2">
                <b>{{ __('Location') }}: </b>
            </div>
            <div class="col-sm-10">{{ __(ucfirst($order->address->location_type)) }}</div>
            <div class="col-sm-2">
                <b>{{ __('Street Name/No') }}: </b>
            </div>
            <div class="col-sm-10">{{ $order->address->street }}</div>
            <div class="col-sm-2">
                <b>{{ __('Building Name/No') }}: </b>
            </div>
            <div class="col-sm-10">{{ $order->address->building }}</div>
            <div class="col-sm-2">
                <b>{{ __('Floor No') }}: </b>
            </div>
            <div class="col-sm-10">{{ $order->address->floor }}</div>
            <div class="col-sm-2">
                <b>{{ __('Apartment No') }}: </b>
            </div>
            <div class="col-sm-10">{{ $order->address->apartment }}</div>
            <div class="col-sm-2">
                <b>{{ __('Nearest Landmark') }}: </b>
            </div>
            <div class="col-sm-10">{{ $order->address->nearest_landmark }}</div>
        </div>
    @endif

    @if ($order->delivery)
        <br>
        <h4>{{ __('Delivery man') }}</h4>
        <div class="row">
            <div class="col-sm-2">
                <a href="{{ route('admins.show', $order->delivery->id) }}"><img src="{{ ($order->delivery->image) ? $order->delivery->image->getUrl('card') : asset(config('default_avatar')) }}" alt="{{ $order->delivery->name }}" class="img-fluid img-circle img-thumbnail"></a>
            </div>
            <div class="col-sm-10">
                <h5><a href="{{ route('admins.show', $order->delivery->id) }}">{{ $order->delivery->name }}</a></h5>
                <div><a href="mailto://{{ $order->delivery->email }}">{{ $order->delivery->email }}</a></div>
                <div>{{ ($order->delivery->personalInfo) ? $order->delivery->personalInfo->phone : '' }}</div>
                <div>{{ ($order->delivery->personalInfo) ? __(ucfirst($order->delivery->personalInfo->gender)) : '' }}</div>
            </div>
        </div>
    @endif

    <br>
    <h4>{{ __('Products') }}</h4>

    <div class="row">
        <div class="table-responsive col-12">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td class="text-center">{{ __('Image') }}</td>
                        <td class="">{{ __('Product Name') }}</td>
                        <td class="">{{ __('Quantity') }}</td>
                        <td class="">{{ __('Unit Price') }}</td>
                        <td class="">{{ __('Total Price') }}</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $product)
                        <tr>
                            <td class="text-center"><a href="{{ route('products.show', $product->id) }}"><img width="70px" src="{{ $product->images->first()->getUrl('thumb') }}" alt="{{ $product->name }}" title="{{ $product->name }}" class="img-thumbnail" /></a></td>
                            <td class=""><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a><br />
                                </td>
                            <td class="" width="200px">{{ $product->pivot->quantity }}</td>
                            <td class="price">
                                @php
                                    $activeDiscount = $product->activeDiscount;
                                    $price = $product->price;
                                @endphp
                                @include('admin.components.pricing')
                            </td>
                            <td class="">{{ $product->pivot->quantity * $product->final_price }} {{ __('LE') }}</td>
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
                            <strong>{{ __('Shipping price') }}:</strong>
                        </td>
                        <td class="text-right">{{ ceil($order->shipping_price) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right">
                            <strong>{{ __('Total Price') }}:</strong>
                        </td>
                        <td class="text-right">{{ ceil($order->total_price + $order->shipping_price + ceil($order->total_price * ($price_tax->value / 100))) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    

