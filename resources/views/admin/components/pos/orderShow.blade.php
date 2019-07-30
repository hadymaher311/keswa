
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
        @if ($order->comment)
            <div class="col-sm-2"><b>{{ __('Comment') }}:</b></div>
            <div class="col-sm-10">{!! $order->comment !!}</div>
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

    @if ($order->worker)
        <br>
        <h4>{{ __('Worker') }}</h4>
        <div class="row">
            <div class="col-sm-2">
                <a href="{{ route('workers.show', $order->worker->id) }}"><img src="{{ ($order->worker->image) ? $order->worker->image->getUrl('card') : asset(config('default_avatar')) }}" alt="{{ $order->worker->name }}" class="img-fluid img-circle img-thumbnail"></a>
            </div>
            <div class="col-sm-10">
                <h5><a href="{{ route('workers.show', $order->worker->id) }}">{{ $order->worker->name }}</a></h5>
                <div><a href="mailto://{{ $order->worker->email }}">{{ $order->worker->email }}</a></div>
                <div>{{ ($order->worker->personalInfo) ? $order->worker->personalInfo->phone : '' }}</div>
                <div>{{ ($order->worker->personalInfo) ? __(ucfirst($order->worker->personalInfo->gender)) : '' }}</div>
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
                            <strong>{{ __('Total Price') }}:</strong>
                        </td>
                        <td class="text-right">{{ ceil($order->total_price + ceil($order->total_price * ($price_tax->value / 100))) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    

