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
        <h2 class="title">{{ __('Checkout') }}</h2>
        <div class="so-onepagecheckout">
        <div class="col-right">
            <div class="row">
            
                <div class="col-sm-12">
                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><i class="fa fa-shopping-cart"></i> {{ __('Shopping Cart') }}</h4>
                    </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
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
                                        @foreach (auth()->user()->cart as $cart)
                                            <tr>
                                                <td class="text-center"><a href="{{ route('user.products.show', [$cart->id, $cart->slug]) }}"><img width="70px" src="{{ $cart->images->first()->getUrl('thumb') }}" alt="{{ $cart->name }}" title="{{ $cart->name }}" class="img-thumbnail" /></a></td>
                                                <td class=""><a href="{{ route('user.products.show', [$cart->id, $cart->slug]) }}">{{ $cart->name }}</a><br /></td>
                                                <form action="{{ route('user.cart.update', $cart->id) }}" id="update-form-{{ $loop->index }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <form action="{{ route('user.cart.remove', $cart->id) }}" id="delete-form-{{ $loop->index }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <td class="" width="200px"><div class="input-group btn-block quantity">
                                                    <input type="text" name="quantity" value="{{ $cart->pivot->quantity }}" size="1" class="form-control" form="update-form-{{ $loop->index }}" />
                                                    <span class="input-group-btn">
                                                    <button type="submit" data-toggle="tooltip" title="{{ __('Update') }}" form="update-form-{{ $loop->index }}" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
                                                    <button type="submit" data-toggle="tooltip" title="{{ __('Delete') }}" form="delete-form-{{ $loop->index }}" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                                                </span></div>
                                                <td class="price">
                                                    @php
                                                        $activeDiscount = $cart->activeDiscount;
                                                        $price = $cart->price;
                                                    @endphp
                                                    @include('user.components.pricing')
                                                </td>
                                                <td class="">{{ $cart->pivot->quantity * $cart->final_price }} {{ __('LE') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="text-right">
                                                <strong>{{ __('Sub-Total Price') }}:</strong>
                                            </td>
                                            <td class="text-left" colspan="4">{{ ceil(auth()->user()->cart_total_price) }} {{ __('LE') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                <strong>{{ __('Price Tax') }} ({{ $price_tax->value }}%):</strong>
                                            </td>
                                            <td class="text-left" colspan="4">{{ ceil(auth()->user()->cart_total_price * ($price_tax->value / 100)) }} {{ __('LE') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-right">
                                                <strong>{{ __('Total Price') }}:</strong>
                                            </td>
                                            <td class="text-left" colspan="4">{{ ceil(auth()->user()->cart_total_price + ceil(auth()->user()->cart_total_price * ($price_tax->value / 100))) }} {{ __('LE') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><i class="fa fa-pencil"></i> {{ __('Add your data') }}</h4>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('user.orders.confirm') }}" method="post">
                                @csrf
                                <h3 for="">{{ __('Choose Address') }} {{ __('or') }} <a href="#go-to-address">{{ __('Add new Address') }}</a></h3>
                                @foreach (auth()->user()->addresses as $address)
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="radio">
                                                <label style="display: block">
                                                    <input type="radio" name="address" {{ (auth()->user()->main_location == $address->id ? 'checked' : '') }} id="optionsRadios{{ $loop->index }}" required value="{{ $address->id }}">
                                                    <div>
                                                        <b>{{ $address->country }}, {{ $address->warehouse_related_location->location_name }}</b>
                                                    </div>
                                                    <div>
                                                        <b>{{ __('Location') }}: </b>{{ __(ucfirst($address->location_type)) }}
                                                    </div>
                                                    <div>
                                                        <b>{{ __('Street Name/No') }}: </b>{{ $address->street }}
                                                    </div>
                                                    <div>
                                                        <b>{{ __('Building Name/No') }}: </b>{{ $address->building }}
                                                    </div>
                                                    <div>
                                                        <b>{{ __('Floor No') }}: </b>{{ $address->floor }}
                                                    </div>
                                                    <div>
                                                        <b>{{ __('Apartment No') }}: </b>{{ $address->apartment }}
                                                    </div>
                                                    <div>
                                                        <b>{{ __('Nearest Landmark') }}: </b>{{ $address->nearest_landmark }}
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <textarea rows="4" class="form-control" placeholder="{{ __('Write Comment here') }} ..." id="confirm_comment" name="comments">{{ old('comments') }}</textarea>
                                <br>
                                <div class="buttons">
                                    <div>
                                        <input type="submit" class="btn btn-primary" id="button-confirm" value="{{ __('Submit') }}">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="panel panel-default" id="go-to-address">
                        <div class="panel-heading">
                            <h4><i class="fa fa-home"></i> {{ __('Add new Address') }}</h4>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('user.addresses.store') }}" method="post" class="form-horizontal account-register clearfix">
                                @csrf
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-country">{{ __('Country') }}</label>
                                    <div class="col-sm-10">
                                        <select id="input-country" class="form-control @error('country') is-invalid @enderror" name="country" required>
                                            <option value=""> --- {{ __('Please Select') }} --- </option>')
                                            <option {{ (old('country') == 'Egypt') ? 'selected' : '' }} value="Egypt">{{ __('Egypt') }}</option>
                                        </select>
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-city">{{ __('City') }}</label>
                                    <div class="col-sm-10">
                                        <select name="city" id="input-city" class="form-control @error('city') is-invalid @enderror" name="city" required>
                                            <option value=""> --- {{ __('Please Select') }} --- </option>')
                                            @foreach ($locations as $location)
                                                <option @if (old('city') == $location->id)
                                                    selected
                                                @endif value="{{ $location->id }}">{{ $location->location_name }}</option>
                                            @endforeach
                                        </select>

                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-street">{{ __('Street Name/No') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="street" placeholder="{{ __('Street Name/No') }}" id="input-street">
    
                                        @error('street')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-building">{{ __('Building Name/No') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('building') is-invalid @enderror" name="building" value="{{ old('building') }}" required autocomplete="building" placeholder="{{ __('Building Name/No') }}" id="input-building">
    
                                        @error('building')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-floor">{{ __('Floor No') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('floor') is-invalid @enderror" name="floor" value="{{ old('floor') }}" required autocomplete="floor" placeholder="{{ __('Floor No') }}" id="input-floor">
    
                                        @error('floor')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-apartment">{{ __('Apartment No') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('apartment') is-invalid @enderror" name="apartment" value="{{ old('apartment') }}" required autocomplete="apartment" placeholder="{{ __('Apartment No') }}" id="input-apartment">
    
                                        @error('apartment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-landmark">{{ __('Nearest Landmark') }}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('nearest_landmark') is-invalid @enderror" name="nearest_landmark" value="{{ old('nearest_landmark') }}" autocomplete="nearest_landmark" placeholder="{{ __('Nearest Landmark') }}" id="input-landmark">
    
                                        @error('nearest_landmark')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-sm-2 control-label" for="input-location_type">{{ __('Location Type') }}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control @error('location_type') is-invalid @enderror" name="location_type" value="{{ old('location_type') }}" required id="input-location_type" class="form-control">
                                            <option value=""> --- {{ __('Please Select') }} --- </option>
                                            <option {{ (old('location_type') == 'home') ? 'selected' : '' }} value="home">{{ __('Home/House') }}</option>
                                            <option {{ (old('location_type') == 'business') ? 'selected' : '' }} value="business">{{ __('Business') }}</option>
                                        </select>
                                        @error('location_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="buttons">
                                    <input type="submit" value="{{ __('Submit') }}" class="btn btn-primary">
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