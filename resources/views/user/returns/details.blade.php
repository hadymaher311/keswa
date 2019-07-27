@extends('user.layouts.app')

@section('title')
    {{ __('Returns') }} - {{ config('app.name') }}
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">
    
    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-9">
            <h2 class="title">
                {{ __('Return Information') }}
                @php
                    $notification = auth()->user()->unreadnotifications()->where('type', 'App\Notifications\User\ReturnWillBeServedLaterNotification')->where('data->return_id', $return->id)->first();
                @endphp
                @if ($notification)
                    <div class="label label-info">{{ __($notification->data['message']) }}</div>
                @endif
            </h2>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td colspan="2" class="text-left">{{ __('Return Details') }}</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%;" class="text-left"> <b>{{ __('Return ID') }}:</b> #{{ $return->id }}</td>
                        <td style="width: 50%;" class="text-left"><b>{{ __('Date Added') }}:</b> {{ $return->created_at }}                  
                        <br>
                        @if ($return->comment)
                            <b>{{ __('Comment') }}:</b> {!! $return->comment !!} </td>
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
                                    <b>{{ $return->address->country }}, {{ $return->address->warehouse_related_location->location_name }}</b>
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
                        </td>
                    </tr>
                </tbody>
            </table>

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-center">{{ __('Image') }}</td>
                            <td class="">{{ __('Product Name') }}</td>
                            <td class="">{{ __('Quantity') }}</td>
                            <td class="">{{ __('Unit Price') }}</td>
                            <td class="">{{ __('Total Price') }}</td>
                            <td style="width: 80px;">
                                @if (!$return->isInTheWay() && !$return->isCompleted() && !$return->isCanceled() && !$return->isDisapproved())
                                    <form action="{{ route('user.orders.cancel', $return->id) }}" method="POST" class="form-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" title="" data-toggle="tooltip" data-original-title="{{ __('Cancel Order') }}"><i class="fa fa-times"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><a href="{{ route('user.products.show', [$return->product->id, $return->product->slug]) }}"><img width="70px" src="{{ $return->product->images->first()->getUrl('thumb') }}" alt="{{ $return->product->name }}" title="{{ $return->product->name }}" class="img-thumbnail" /></a></td>
                            <td class=""><a href="{{ route('user.products.show', [$return->product->id, $return->product->slug]) }}">{{ $return->product->name }}</a><br />
                                </td>
                            <td class="" width="200px">{{ $return->quantity }}</td>
                            <td class="price">
                                @php
                                    $activeDiscount = $return->product->activeDiscount;
                                    $price = $return->product->price;
                                @endphp
                                @include('user.components.pricing')
                            </td>
                            <td class="">{{ $return->quantity * $return->product->final_price }} {{ __('LE') }}</td>
                            <td style="white-space: nowrap;" class="text-right">
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <h3>{{ __('Return History') }}</h3>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <td class="text-left">{{ __('Date Added') }}</td>
                        <td class="text-left">{{ __('Status') }}</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($return->statuses as $status)
                        <tr>
                            <td class="text-left">{{ $status->created_at }}</td>
                            <td class="text-left">
                                @php
                                    $return_status = $status->name;
                                @endphp
                                @include('user.components.returnStatusColor')
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