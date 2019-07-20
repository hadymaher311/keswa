@extends('admin.layouts.app')

@section('title')
{{ __('Add new product') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/select2/dist/css/select2.min.css') }}">    
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Warehouses') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add new product to warehouse') }}</h4> <br>
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
                    <form action="{{ route('warehouses.add.product', $warehouse->id) }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="product" class="col-sm-3 col-form-label">{{ __('Product') }}</label>
                            <div class="col-sm-9">
                                <select name="product" id="product" class="form-control select2 @error('product') is-invalid @enderror">
                                    <option value="">--- {{ __('Please Select') }} ---</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->sku }} - {{ $product->upc }}</option>
                                    @endforeach
                                </select>
                                
                                @error('product')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="quantity" class="col-sm-3 col-form-label">{{ __('Quantity') }}</label>
                            <div class="col-sm-9">
                                <input id="quantity" type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity') }}" autocomplete="quantity">
                                
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expiry_date" class="col-sm-3 col-form-label">{{ __('Expiry date') }}</label>
                            <div class="col-sm-9">
                                <input id="expiry_date" type="text" class="
                                    @if (app()->getLocale() == 'ar')
                                    pull-right
                                    @endif form-control datepicker @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date') }}" required autocomplete="expiry_date">

                                @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('js')
<script src="{{ asset('/admin_styles/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script>
    $(function() {
        $(".inputtags").tagsinput('items');
    })
</script>
@endsection