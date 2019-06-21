@extends('admin.layouts.app')

@section('title')
{{ __('Edit product') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/dropzonejs/dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/chocolat/dist/css/chocolat.css') }}">
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
                    <h4>{{ __('Edit product') }}</h4> <br>
                    @can('create products')
                        <a href="{{ route('products.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new product') }}</a>
                    @endcan
                    @can('view products')
                        <a href="{{ route('products.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
                    @endcan
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
                    <form action="{{ route('products.images.edit', $product->id) }}" id="image-form" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Current images') }}</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    @foreach ($product->images as $image)
                                        <div class="col-sm-3">
                                            <div class="card image-card">
                                                <div class="card-body p-0">
                                                    <span class="badge badge-danger mb-3 ml-3 mr-3 remove-image" style="cursor: pointer" data-toggle="tooltip" data-placement="top" title="{{ __('Remove image') }}"><i class="fa fa-times"></i></span>
                                                    <img alt="image" data-id="{{ $image->id }}" src="{{ $image->getUrl('card') }}" class="img-fluid">    
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
<script src="{{ asset('/admin_styles/modules/dropzonejs/min/dropzone.min.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
<script>

    $(function() {
        "use strict";

        var dropzone = new Dropzone("#mydropzone", {
            url: "#",
            addRemoveLinks: true,
            autoProcessQueue: false,
            dictDefaultMessage: "{{ __('Choose Images') }}",
        });

        $(".remove-image").on('click', function(e) {
            var imageId = $(this).next('img').data('id')
            $(this).parents('form#image-form').append('<input type="hidden" name="removed[]" value="' + imageId + '">')
            $(this).tooltip('hide')
            $(this).parents('.card.image-card').parent('.col-sm-3').remove()
        })

        $("#submit-btn").on('click', function(e) {
            e.preventDefault();
            for (let index = 0; index < dropzone.files.length; index++) {
                const file_data = dropzone.files[index].dataURL;
                $(this).parents('form').append('<input type="hidden" name="images[]" value="' + file_data + '">')
            }
            $(this).parents('form').submit()
        })
    });
</script>
@endsection