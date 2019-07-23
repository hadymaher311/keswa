@extends('user.layouts.app')

@section('title')
    {{ __('Checkout') }} - {{ config('app.name') }}
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">
    
    <div class="row">
        <!--Middle Part Start-->
    <div id="content" class="col-sm-9">
        <h2 class="title">{{ __('Confirm Order') }}</h2>
        <div class="so-onepagecheckout">
        <div class="col-right">
            <div class="row">
            
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-pencil"></i> {{ __('Confirm Order') }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-danger text-center">{{ __('We are not working in this hour, your order will be served soon') }}</div>
                            <form action="{{ route('user.orders.confirm') }}" method="post">
                                @csrf
                                <input type="hidden" name="comment" value="{{ $comment }}">
                                <input type="hidden" name="address" value="{{ $address }}">
                                <input type="hidden" name="confirm" value="confirm">
                                <div class="buttons">
                                    <div>
                                        <input type="submit" class="btn btn-primary" id="button-confirm" value="{{ __('Confirm') }}">
                                        <a href="{{ route('welcome') }}" class="btn btn-danger" id="button-confirm">{{ __('Discard') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>

    @include('user.components.accountSideLinks')
    <!--Middle Part End -->
        
    </div>
</div>
<!-- //Main Container -->
@endsection