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
        <h2 class="title">{{ __('Returns') }}</h2>
        <div class="table-responsive form-group">
            <table class="table table-bordered">
            <thead>
                <tr>
                <td class="text-center">{{ __('Return ID') }}</td>
                <td class="">{{ __('Product') }}</td>
                <td class="">{{ __('Quantity') }}</td>
                <td class="">{{ __('Status') }}</td>
                <td class="">{{ __('Date Added') }}</td>
                <td class="">{{ __('View') }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach (auth()->user()->returns as $return)
                    <tr>
                        <td class="text-center">#{{ $return->id }}</td>
                        <td class="">{{ $return->product->name }}</td>
                        <td class="">{{ $return->quantity }}</td>
                        <td class="">
                            @php
                                $return_status = $return->statuses->last()->name;
                            @endphp
                            @include('user.components.returnStatusColor')
                            &nbsp;
                            @php
                                $notification = auth()->user()->unreadnotifications()->where('type', 'App\Notifications\User\ReturnWillBeServedLaterNotification')->where('data->return_id', $return->id)->first();
                            @endphp
                            @if ($notification)
                                <div class="label label-info">{{ __($notification->data['message']) }}</div>
                            @endif
                        </td>
                        <td class="">{{ $return->created_at }}</td>
                        <td class="">
                            <a class="btn btn-info" title="" data-toggle="tooltip" href="{{ route('user.returns.details', $return->id) }}" data-original-title="{{ __('View') }}"><i class="fa fa-eye"></i></a>
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