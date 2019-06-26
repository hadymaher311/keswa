@extends('user.layouts.app')

@section('title')
    {{ auth()->user()->name }} - {{ __('Reviews') }} - {{ config('app.name') }}
@endsection

@section('css')
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">

    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-9">
            <div class="row">
                <div class="col-sm-12">
                    <form action="{{ route('user.reviews.update', $review->id) }}" method="post" class="form-horizontal account-register clearfix">
                        @csrf
                        @method('PUT')
                        <fieldset id="address">
                            <legend>{{ __('Edit Review') }}</legend>
                            <div class="form-group"> <span class="icon icon-bubbles-2"></span>
                                <textarea class="form-control @error('content') is-invalid @enderror" placeholder="{{ __('Your Review') }}" name="content" required>{!! $review->content !!}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> 
                            <div class="form-group">
                                <b>{{ __('Rating') }}</b> <span>{{ __('Bad') }}</span>&nbsp;
                                @foreach (range(1, 5) as $rate)
                                    <input type="radio" {{ ($rate == $review->rate) ? 'checked' : '' }} required name="rate" value="{{ $rate }}"> &nbsp;
                                @endforeach
                                <span>{{ __('Good') }}</span>
                                @error('rating')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                            </div>
                        </fieldset>
                        <div class="buttons">
                            <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('user.components.accountSideLinks')

    </div>
</div>
<!-- //Main Container -->
@endsection

@section('js')

@endsection
