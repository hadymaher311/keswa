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
        <h2 class="title">{{ __('Orders') }}</h2>
        <div class="table-responsive form-group">
            <table class="table table-bordered">
            <thead>
                <tr>
                <td class="text-center">{{ __('Order ID') }}</td>
                <td class="">{{ __('Status') }}</td>
                <td class="">{{ __('Date Added') }}</td>
                <td class="">{{ __('Total Price') }}</td>
                <td class="">{{ __('View') }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach (auth()->user()->orders as $order)
                    <tr>
                        <td class="text-center">#{{ $order->id }}</td>
                        @php
                            $status_colors = [
                                'Waiting for confirmation' => 'primary',
                                'Approved' => 'primary',
                                'Shipped' => 'info',
                                'Completed' => 'success',
                                'Canceled' => 'danger',
                                'Shipping returned' => 'danger',
                            ];
                        @endphp
                        <td class="">
                            <span class="label label-{{ $status_colors[$order->statuses->last()->name] }}">{{ __($order->statuses->last()->name) }}</span>&nbsp;
                            @php
                                $notification = auth()->user()->unreadnotifications()->where('type', 'App\Notifications\User\OrderWillBeServedLaterNotification')->where('data->order_id', $order->id)->first();
                            @endphp
                            @if ($notification)
                                <div class="label label-info">{{ __($notification->data['message']) }}</div>
                            @endif
                        </td>
                        <td class="">{{ $order->created_at }}</td>
                        <td class="price">
                            {{ $order->total_price }} {{ __('LE') }}
                        </td>
                        <td class="">
                            <a class="btn btn-info" title="" data-toggle="tooltip" href="{{ route('user.orders.details', $order->id) }}" data-original-title="{{ __('View') }}"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>

    @include('user.components.accountSideLinks')
    <!--Middle Part End -->
        
    </div>
</div>
<!-- //Main Container -->
@endsection