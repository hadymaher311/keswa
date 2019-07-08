@extends('admin.layouts.app')

@section('title')
{{ __('Add new order') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/select2/dist/css/select2.min.css') }}">    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Orders') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add new order') }}</h4> <br>
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
                    <form action="{{ route('orders.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('User') }}</label>
                            <div class="col-sm-8">
                                <select id="user" type="text" class="form-control select2 @error('user') is-invalid @enderror" name="user" required autocomplete="user" autofocus>
                                    <option value="">{{ __('Choose user') }}</option>
                                    @foreach ($users as $user)
                                        <option @if ($user->id == old('user'))
                                            selected
                                        @endif value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                                    @endforeach
                                </select>
                                
                                @error('user')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-sm-1">
                                <a href="{{ route('users.create') }}" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="{{ __('Add new user') }}"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>

                        <div class="form-group row products">
                            <label for="product" class="col-sm-3 control-label">{{ __('Products') }}</label>
        
                            <div class="col-sm-4">
                                <select id="product" class="form-control select2 @error('products') is-invalid @enderror" name="products[]" autocomplete="products">
                                    <option value="">{{ __('Choose product') }}</option>
                                    @foreach ($products as $product)
                                        <option @if ($product->id == old('products')[0])
                                            selected
                                        @endif value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>

                                @error('products')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-sm-4">
                                <input id="quantity" type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" name="quantity[]" value="{!! old('quantity')[0]  !!}" autocomplete="quantity" placeholder="{{ __('Quantity') }}">

                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-1">
                                <button class="btn btn-sm btn-success add-product" data-toggle="tooltip" data-placement="top" title="{{ __('Add new product') }}"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Comment') }}</label>
                            <div class="col-sm-8">
                                <textarea id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" required autocomplete="comment">{{ old('comment') }}</textarea>
                                
                                @error('comment')
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
<script src="{{ asset('/admin_styles/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        var product_body = '<div class="col-sm-3 product-box mt-3"></div>';
        product_body    += '<div class="col-sm-4 product-box mt-3">';
        product_body    += '<select id="product" type="text" class="form-control select2" name="products[]" required>';
        product_body    += '<option value="">{{ __('Choose product') }}</option>';
        @foreach ($products as $product)
            product_body    += '<option value="{{ $product->id }}">{{ $product->name }}</option>';
        @endforeach
        product_body    += '</select>';
        product_body    += '</div>';
        
        product_body    += '<div class="col-sm-4 product-box mt-3">';
        product_body    += '<input id="quantity" value="1" type="number" min="1" class="form-control" name="quantity[]" autocomplete="quantity" placeholder="{{ __('Quantity') }}">';
        product_body    += '</div>';
            
        product_body    += '<div class="col-sm-1 product-box mt-3">';
        product_body    += '<button class="btn btn-sm btn-danger remove-product" data-toggle="tooltip" data-placement="top" title="{{ __('Remove product') }}"><i class="fa fa-minus"></i></button>';
        product_body    += '</div>';

        $(".products").on('click', '.add-product', function(e) {
            e.preventDefault()
            $(this).parents('.products').append(product_body)
            $("*[data-toggle=tooltip]").tooltip()
            $(this).tooltip('hide')
            $('.select2').select2()
        })
        $(".products").on('click', '.remove-product', function(e) {
            e.preventDefault()
            $(this).tooltip('hide')
            $(this).parent('.product-box').prev('.product-box').remove();
            $(this).parent('.product-box').prev('.product-box').remove();
            $(this).parent('.product-box').prev('.product-box').remove();
            $(this).parent('.product-box').remove();
        })
    })
</script>
@endsection