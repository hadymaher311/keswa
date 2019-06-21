@extends('admin.layouts.app')

@section('title')
{{ __('Add new product') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/dropzonejs/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Products') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add new product') }}</h4> <br>
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
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            {{ __($error) }}
                            </div>
                        </div>
                    @endforeach
                    <form action="{{ route('products.store') }}" id="product-form" method="post" enctype="multipart/form-data">
                        @csrf
                        <ul class="nav nav-pills" id="myTab3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="basic-tab3" data-toggle="tab" href="#basic3" role="tab" aria-controls="basic" aria-selected="true">{{ __('Basic Info') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="quantity-tab3" data-toggle="tab" href="#quantity3" role="tab" aria-controls="quantity" aria-selected="false">{{ __('Quantities') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pricing-tab3" data-toggle="tab" href="#pricing3" role="tab" aria-controls="pricing" aria-selected="false">{{ __('Pricing') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="shipping-tab4" data-toggle="tab" href="#shipping4" role="tab" aria-controls="shipping4" aria-selected="false">{{ __('Shipping') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="features-tab5" data-toggle="tab" href="#features5" role="tab" aria-controls="features5" aria-selected="false">{{ __('Features') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="other-tab6" data-toggle="tab" href="#other6" role="tab" aria-controls="other6" aria-selected="false">{{ __('Other') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent2">

                            {{------------------------------------------Basic Info  ----------------------------------------------}}

                            <div class="tab-pane fade show active" id="basic3" role="tabpanel" aria-labelledby="basic-tab3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Name') }} {{ __('in English') }}</label>
                                    <div class="col-sm-9">
                                        <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ old('name_en') }}" autocomplete="name_en" autofocus>
                                        
                                        @error('name_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Name') }} {{ __('in Arabic') }}</label>
                                    <div class="col-sm-9">
                                        <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{ old('name_ar') }}" autocomplete="name_ar">
                                        
                                        @error('name_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('SKU') }}</label>
                                    <div class="col-sm-9">
                                        <input id="sku" type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" value="{{ old('sku') }}" required autocomplete="sku">
                                        
                                        @error('sku')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Expiry date') }}</label>
                                    <div class="col-sm-9">
                                        <input id="expiry_date" type="text" class="
                                        @if (app()->getLocale() == 'ar')
                                        pull-right
                                        @endif form-control datepicker @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date') }}" required autocomplete="expiry_date">
                                        
                                        @error('expiry_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Short description') }} {{ __('in English') }}</label>
                                    <div class="col-sm-9">
                                        <textarea id="short_description_en" type="text" class="summernote-simple form-control @error('short_description_en') is-invalid @enderror" name="short_description_en" autocomplete="short_description_en">
                                                {!! old('short_description_en') !!}
                                        </textarea>
                                        
                                        @error('short_description_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Short description') }} {{ __('in Arabic') }}</label>
                                    <div class="col-sm-9">
                                        <textarea id="short_description_ar" type="text" class="summernote-simple form-control @error('short_description_ar') is-invalid @enderror" name="short_description_ar" autocomplete="short_description_ar">
                                                {!! old('short_description_ar') !!}
                                        </textarea>
                                        
                                        @error('short_description_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Description') }} {{ __('in English') }}</label>
                                    <div class="col-sm-9">
                                        <textarea id="description_en" type="text" class="summernote-simple form-control @error('description_en') is-invalid @enderror" name="description_en" autocomplete="description_en">
                                                {!! old('description_en') !!}
                                        </textarea>
                                        
                                        @error('description_en')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Description') }} {{ __('in Arabic') }}</label>
                                    <div class="col-sm-9">
                                        <textarea id="description_ar" type="text" class="summernote-simple form-control @error('description_ar') is-invalid @enderror" name="description_ar" autocomplete="description_ar">
                                                {!! old('description_ar') !!}
                                        </textarea>
                                        
                                        @error('description_ar')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-3 control-label">{{ __('Categories') }}</label>
                
                                    <div class="col-sm-9">
                                        <select name="categories[]" id="categories" required class="form-control select2 @error('categories[]') is-invalid @enderror" multiple>
                                            @foreach ($sub_sub_categories as $category)
                                                <option 
                                                    @if (old('categories'))
                                                        @foreach (old('categories') as $cat)
                                                            @if ($category->id == $cat)
                                                                selected
                                                            @endif     
                                                        @endforeach
                                                    @endif
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('categories[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-3 control-label">{{ __('Brand') }}</label>
                
                                    <div class="col-sm-9">
                                        <select name="brand" id="brand" required class="form-control @error('brand') is-invalid @enderror">
                                            <option value="">{{ __('Choose brand') }}</option>
                                            @foreach ($brands as $brand)
                                                <option @if ($brand->id == old('brand'))
                                                    selected
                                                @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
        
                                        @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Images') }}</label>
                                    <div class="col-sm-9">
                                        <div id="mydropzone" class="dropzone">
                                            <div class="fallback">
                                                <input required accept="image/*" name="images[]" id="image-upload" type="file" multiple />
                                            </div>
                                            
                                            @error('images')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{------------------------------------------Basic Info  ----------------------------------------------}}

                            {{------------------------------------------Quantity  ----------------------------------------------}}
                            <div class="tab-pane fade" id="quantity3" role="tabpanel" aria-labelledby="quantity-tab3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Quantity') }}</label>
                                    <div class="col-sm-9">
                                        <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" min="1" value="{{ old('quantity')  }}" required autocomplete="quantity">
                                        
                                        @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Low quantity') }}</label>
                                    <div class="col-sm-9">
                                        <input id="low_quantity" type="number" class="form-control @error('low_quantity') is-invalid @enderror" name="low_quantity" min="1" value="{{ old('low_quantity')  }}" required autocomplete="low_quantity">
                                        
                                        @error('low_quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Quantity pre packet') }}</label>
                                    <div class="col-sm-9">
                                        <input id="quantity_per_packet" type="number" class="form-control @error('quantity_per_packet') is-invalid @enderror" name="quantity_per_packet" min="1" value="{{ old('quantity_per_packet')  }}" required autocomplete="quantity_per_packet">
                                        
                                        @error('quantity_per_packet')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Min sale quantity') }}</label>
                                    <div class="col-sm-9">
                                        <input id="min_sale_quantity" type="number" class="form-control @error('min_sale_quantity') is-invalid @enderror" name="min_sale_quantity" min="1" value="{{ old('min_sale_quantity')  }}" required autocomplete="min_sale_quantity">
                                        
                                        @error('min_sale_quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            {{------------------------------------------Quantity  ----------------------------------------------}}

                            {{------------------------------------------ Pricing ----------------------------------------------}}
                            <div class="tab-pane fade" id="pricing3" role="tabpanel" aria-labelledby="pricing-tab3">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Cost') }}</label>
                                    <div class="col-sm-9">
                                        <input id="cost" type="number" class="form-control @error('cost') is-invalid @enderror" name="cost" min="1" value="{{ old('cost')  }}" required autocomplete="cost">
                                        
                                        @error('cost')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Price') }}</label>
                                    <div class="col-sm-9">
                                        <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" min="1" value="{{ old('price')  }}" required autocomplete="price">
                                        
                                        @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-3 control-label">{{ __('Discount') }}</label>
                
                                    @php
                                        $discounts = [
                                            'value' => trans('By value'),
                                            'percentage' => trans('By percentage'),
                                        ]
                                    @endphp
                                    <div class="col-sm-3">
                                        <select name="discount" id="discount" class="form-control @error('discount') is-invalid @enderror">
                                            <option value="">{{ __('Choose discount') }} ({{ __('No discount') }})</option>
                                            @foreach ($discounts as $discount => $value)
                                                <option @if ($discount == old('discount'))
                                                    selected
                                                @endif value="{{ $discount }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
        
                                        @error('discount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <input id="discount_value" type="number" class="form-control @error('discount_value') is-invalid @enderror" name="discount_value" min="1" value="{{ old('discount_value')  }}" autocomplete="discount_value" placeholder="{{ __('Value') }}">
                                        
                                        @error('discount_value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <input id="discount_amount" type="number" class="form-control @error('discount_amount') is-invalid @enderror" name="discount_amount" min="1" value="{{ old('discount_amount')  }}" autocomplete="discount_amount" placeholder="{{ __('Quantity') }}">
                                        
                                        @error('discount_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{------------------------------------------ Pricing ----------------------------------------------}}

                            {{------------------------------------------ Shipping ----------------------------------------------}}
                            <div class="tab-pane fade" id="shipping4" role="tabpanel" aria-labelledby="shipping-tab4">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Dimensions') }} {{ __('in cm') }}</label>
                                    <div class="col-sm-3">
                                        <input id="width" type="number" class="form-control @error('width') is-invalid @enderror" name="width" min="1" value="{{ old('width')  }}" autocomplete="width" placeholder="{{ __('Width') }}">
                                        
                                        @error('width')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <input id="length" type="number" class="form-control @error('length') is-invalid @enderror" name="length" min="1" value="{{ old('length')  }}" autocomplete="length" placeholder="{{ __('Length') }}">
                                        
                                        @error('length')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <input id="depth" type="number" class="form-control @error('depth') is-invalid @enderror" name="depth" min="1" value="{{ old('depth')  }}" autocomplete="depth" placeholder="{{ __('Depth') }}">
                                        
                                        @error('depth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Weight in Kg') }}</label>
                                    <div class="col-sm-9">
                                        <input id="weight" type="number" class="form-control @error('weight') is-invalid @enderror" name="weight" min="1" value="{{ old('weight')  }}" required autocomplete="weight">
                                        
                                        @error('weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-3 control-label">{{ __('Warehouses') }}</label>
                
                                    <div class="col-sm-9">
                                        <select name="warehouse" id="warehouse" required class="form-control @error('warehouse') is-invalid @enderror">
                                            <option value="">{{ __('Choose warehouse') }}</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option @if ($warehouse->id == old('warehouse'))
                                                    selected
                                                @endif value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                            @endforeach
                                        </select>
        
                                        @error('warehouse')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{------------------------------------------ Shipping ----------------------------------------------}}

                            {{------------------------------------------ Features ----------------------------------------------}}
                            <div class="tab-pane fade" id="features5" role="tabpanel" aria-labelledby="features-tab5">
                                <div class="form-group row features">
                                    <label for="inputEmail" class="col-sm-3 control-label">{{ __('Features') }}</label>
                
                                    <div class="col-sm-4">
                                        <input id="feature_type" feature_type="text" class="form-control @error('feature_type') is-invalid @enderror" name="feature_type[]" value="{!! old('feature_type')[0]  !!}" autocomplete="feature_type" placeholder="{{ __('Type') }}">
        
                                        @error('feature_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-sm-4">
                                        <input id="feature_value" feature_value="text" class="form-control @error('feature_value') is-invalid @enderror" name="feature_value[]" value="{!! old('feature_value')[0]  !!}" autocomplete="feature_value" placeholder="{{ __('Value') }}">
        
                                        @error('feature_value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-1">
                                        <button class="btn btn-sm btn-success add-feature" data-toggle="tooltip" data-placement="top" title="{{ __('Add new feature') }}"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            {{------------------------------------------ Features ----------------------------------------------}}

                            {{------------------------------------------ Other ----------------------------------------------}}
                            <div class="tab-pane fade" id="other6" role="tabpanel" aria-labelledby="other-tab6">

                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-3 control-label">{{ __('Related products') }}</label>
                
                                    <div class="col-sm-9">
                                        <select name="related_product[]" id="related_product" class="form-control select2 @error('related_product[]') is-invalid @enderror" multiple>
                                            @foreach ($products as $product)
                                                <option 
                                                @if (old('related_product'))
                                                    @foreach (old('related_product') as $related)
                                                        @if ($product->id == $related)
                                                            selected
                                                        @endif 
                                                    @endforeach
                                                @endif
                                                value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('related_product[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-3 control-label">{{ __('Accessories') }}</label>
                
                                    <div class="col-sm-9">
                                        <select name="accessories[]" id="accessories" class="form-control select2 @error('accessories') is-invalid @enderror" multiple>
                                            @foreach ($products as $product)
                                                <option
                                                @if (old('accessories'))
                                                    @foreach (old('accessories') as $accessory)
                                                        @if ($product->id == $accessory)
                                                            selected
                                                        @endif 
                                                    @endforeach
                                                @endif
                                                value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('accessories[]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ __('Tags') }}</label>
                                    <div class="col-sm-9">
                                        <input id="tags" type="text" class="form-control inputtags @error('tags') is-invalid @enderror" name="tags" value="{{ old('tags') }}" autocomplete="tags">
                                        
                                        @error('tags')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            {{------------------------------------------ Other ----------------------------------------------}}

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" id="submit-btn" class="btn btn-warning btn-block">{{ __('Submit') }}</button>
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
<script src="{{ asset('/admin_styles/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/dropzonejs/min/dropzone.min.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script>

    $(function() {
        "use strict";

        var dropzone = new Dropzone("#mydropzone", {
            url: "#",
            addRemoveLinks: true,
            autoProcessQueue: false,
            dictDefaultMessage: "{{ __('Choose Images') }}",
        });

        $(".inputtags").tagsinput('items');

        var feature_body = '<div class="col-sm-3 feature-box mt-3"></div>';
        feature_body    += '<div class="col-sm-4 feature-box mt-3">';
        feature_body    += '<input id="feature_type" feature_type="text" class="form-control" name="feature_type[]" autocomplete="feature_type" placeholder="{{ __('Type') }}">';
        feature_body    += '</div>';
        
        feature_body    += '<div class="col-sm-4 feature-box mt-3">';
        feature_body    += '<input id="feature_value" feature_value="text" class="form-control" name="feature_value[]" autocomplete="feature_value" placeholder="{{ __('Value') }}">';
        feature_body    += '</div>';
            
        feature_body    += '<div class="col-sm-1 feature-box mt-3">';
        feature_body    += '<button class="btn btn-sm btn-danger remove-feature" data-toggle="tooltip" data-placement="top" title="{{ __('Remove feature') }}"><i class="fa fa-minus"></i></button>';
        feature_body    += '</div>';

        $(".features").on('click', '.add-feature', function(e) {
            e.preventDefault()
            $(this).parents('.features').append(feature_body)
            $("*[data-toggle=tooltip]").tooltip()
        })
        $(".features").on('click', '.remove-feature', function(e) {
            e.preventDefault()
            $(this).parent('.feature-box').prev('.feature-box').remove();
            $(this).parent('.feature-box').prev('.feature-box').remove();
            $(this).parent('.feature-box').prev('.feature-box').remove();
            $(this).parent('.feature-box').remove();
        })

    
        $("#submit-btn").on('click', function(e) {
            e.preventDefault();
            if (dropzone.files.length <= 0) {
                alert("{{ __('No Images Selected') }}")
            }
            else {
                for (let index = 0; index < dropzone.files.length; index++) {
                    const file_data = dropzone.files[index].dataURL;
                    $(this).parents('form').append('<input type="hidden" name="images[]" value="' + file_data + '">')
                }
                $(this).parents('form').submit()
            }
        })

    })

</script>
@endsection