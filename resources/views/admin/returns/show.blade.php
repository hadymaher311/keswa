@extends('admin.layouts.app')

@section('title')
{{ __('View return') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Returns') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('View return') }}</h4> <br>
                    @can('update returns')
                        @can('return.update', $return)
                            <a href="{{ route('returns.edit', $return->id) }}" class="btn btn-warning m-3"><i class="fa fa-edit"></i> {{ __('Edit') }}</a>
                        @endcan
                    @endcan
                    <a href="{{ route('returns.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                    <h3>{{ __('Return ID') }}: #{{ $return->id }}</h3>
                    <div class="row">
                        <div class="col-sm-2"><b>{{ __('Warehouse') }}:</b></div>
                        <div class="col-sm-10">
                            <a href="{{ route('warehouses.show', $return->warehouse->id) }}">{{ $return->warehouse->name }}</a>
                        </div>
                        
                        <div class="col-sm-2"><b>{{ __('Order') }}:</b></div>
                        <div class="col-sm-10">
                            <a href="{{ route('orders.show', $return->order->id) }}">#{{ $return->order->id }}</a>
                        </div>

                        @if ($return->comment)
                            <div class="col-sm-2"><b>{{ __('Comment') }}:</b></div>
                            <div class="col-sm-10">{!! $return->comment !!}</div>
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
                        @if ($return->isDisapproved())
                            <div class="wizard-step wizard-step-danger">
                                <div class="wizard-step-icon">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="wizard-step-label">
                                    {{ __('Disapproved') }}
                                </div>
                            </div>
                        @else
                            <div class="wizard-step @if($return->isApproved())
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
                        <div class="wizard-step @if($return->isInTheWay())
                            wizard-step-info
                        @else
                            wizard-step-default
                        @endif">
                            <div class="wizard-step-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="wizard-step-label">
                                {{ __('In the way') }}
                            </div>
                        </div>
                        @if ($return->isReturnDenied())
                            <div class="wizard-step @if($return->isReturnDenied())
                                wizard-step-danger
                            @else
                                wizard-step-default
                            @endif">
                                <div class="wizard-step-icon">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="wizard-step-label">
                                    {{ __('Shipping returned') }}
                                </div>
                            </div>
                        @endif
                        @if (!$return->isReturnDenied())
                            @if ($return->isCompleted())
                                <div class="wizard-step @if($return->isCompleted())
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
                            @elseif($return->isCompletedScrapped())
                                <div class="wizard-step @if($return->isCompletedScrapped())
                                    wizard-step-danger
                                @else
                                    wizard-step-default
                                @endif">
                                    <div class="wizard-step-icon">
                                    <i class="fas fa-prescription-bottle-alt"></i>
                                    </div>
                                    <div class="wizard-step-label">
                                    {{ __('Completed scrapped') }}
                                    </div>
                                </div>
                            @else
                                <div class="wizard-step @if($return->isCompleted())
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
                            @endif
                        @endif
                        @if ($return->isCanceled())
                            <div class="wizard-step @if($return->isCanceled())
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
                    <h4>{{ __('Return History') }}</h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>{{ __('Date Added') }}</td>
                                <td>{{ __('Status') }}</td>
                                <td>{{ __('Comment') }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($return->statuses as $status)
                                <tr>
                                    <td>{{ $status->created_at }}</td>
                                    <td>
                                        @php
                                            $return_status = $status->name;
                                        @endphp
                                        @include('admin.components.returnStatusColor')
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
                            <a href="{{ route('users.show', $return->user->id) }}"><img src="{{ ($return->user->image) ? $return->user->image->getUrl('card') : asset(config('default_avatar')) }}" alt="{{ $return->user->name }}" class="img-fluid img-circle img-thumbnail"></a>
                        </div>
                        <div class="col-sm-10">
                            <h5><a href="{{ route('users.show', $return->user->id) }}">{{ $return->user->name }}</a></h5>
                            <div><a href="mailto://{{ $return->user->email }}">{{ $return->user->email }}</a></div>
                            <div>{{ ($return->user->personalInfo) ? $return->user->personalInfo->phone : '' }}</div>
                            <div>{{ ($return->user->personalInfo) ? __(ucfirst($return->user->personalInfo->gender)) : '' }}</div>
                        </div>
                    </div>

                    @if ($return->address)
                        <br>
                        <h4>{{ __('Address') }}</h4>
                        <b>{{ __($return->address->country) }}, {{ __($return->address->city) }}</b>
                        <div class="row">
                            <div class="col-sm-2">
                                <b>{{ __('Location') }}: </b>
                            </div>
                            <div class="col-sm-10">{{ __(ucfirst($return->address->location_type)) }}</div>
                            <div class="col-sm-2">
                                <b>{{ __('Street Name/No') }}: </b>
                            </div>
                            <div class="col-sm-10">{{ $return->address->street }}</div>
                            <div class="col-sm-2">
                                <b>{{ __('Building Name/No') }}: </b>
                            </div>
                            <div class="col-sm-10">{{ $return->address->building }}</div>
                            <div class="col-sm-2">
                                <b>{{ __('Floor No') }}: </b>
                            </div>
                            <div class="col-sm-10">{{ $return->address->floor }}</div>
                            <div class="col-sm-2">
                                <b>{{ __('Apartment No') }}: </b>
                            </div>
                            <div class="col-sm-10">{{ $return->address->apartment }}</div>
                            <div class="col-sm-2">
                                <b>{{ __('Nearest Landmark') }}: </b>
                            </div>
                            <div class="col-sm-10">{{ $return->address->nearest_landmark }}</div>
                        </div>
                    @endif

                    @if ($return->delivery)
                        <br>
                        <h4>{{ __('Delivery man') }}</h4>
                        <div class="row">
                            <div class="col-sm-2">
                                <a href="{{ route('admins.show', $return->delivery->id) }}"><img src="{{ ($return->delivery->image) ? $return->delivery->image->getUrl('card') : asset(config('default_avatar')) }}" alt="{{ $return->delivery->name }}" class="img-fluid img-circle img-thumbnail"></a>
                            </div>
                            <div class="col-sm-10">
                                <h5><a href="{{ route('admins.show', $return->delivery->id) }}">{{ $return->delivery->name }}</a></h5>
                                <div><a href="mailto://{{ $return->delivery->email }}">{{ $return->delivery->email }}</a></div>
                                <div>{{ ($return->delivery->personalInfo) ? $return->delivery->personalInfo->phone : '' }}</div>
                                <div>{{ ($return->delivery->personalInfo) ? __(ucfirst($return->delivery->personalInfo->gender)) : '' }}</div>
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
                                    <tr>
                                        <td class="text-center"><a href="{{ route('products.show', $return->product->id) }}"><img width="70px" src="{{ $return->product->images->first()->getUrl('thumb') }}" alt="{{ $return->product->name }}" title="{{ $return->product->name }}" class="img-thumbnail" /></a></td>
                                        <td class=""><a href="{{ route('products.show', $return->product->id) }}">{{ $return->product->name }}</a><br />
                                            </td>
                                        <td class="" width="200px">{{ $return->quantity }}</td>
                                        <td class="price">
                                            @php
                                                $activeDiscount = $return->product->activeDiscount;
                                                $price = $return->product->price;
                                            @endphp
                                            @include('admin.components.pricing')
                                        </td>
                                        <td class="">{{ $return->quantity * $return->product->final_price }} {{ __('LE') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('returns.invoice', $return->id) }}" class="btn btn-warning">
                                <i class="far fa-file-pdf"></i> {{ __('Invoice') }}
                            </a>
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