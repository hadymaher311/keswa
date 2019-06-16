@extends('admin.layouts.app')

@section('title')
{{ __('Edit admin') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/admin_styles/css/croppie.css') }}">
    <style>
        .croppie-container .cr-image {
            position: relative;
        }
    </style>
@endsection

@section('body')
<div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ auth()->user()->name }}</h4>
                </div>
                <div class="card-body">
                    
                    <div class="section-body">
            
                        <div id="output-status"></div>
                        <div class="row">
                            <div class="col-md-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                <h4>{{ __('Go To') }}</h4>
                                </div>
                                <div class="card-body">
                                    @include('admin.profile.navigation')
                                </div>
                            </div>
                            </div>
                            <div class="col-md-8">
                                <div class="section-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card card-primary">
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
                                                <form action="{{ route('admin.profile.edit') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    {{ method_field('PUT') }}
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">{{ __('First Name') }}</label>
                                                        <div class="col-sm-9">
                                                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ auth()->user()->first_name }}" required autocomplete="first_name" autofocus>

                                                            @error('first_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">{{ __('Last Name') }}</label>
                                                        <div class="col-sm-9">
                                                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ auth()->user()->last_name }}" required autocomplete="last_name" autofocus>

                                                            @error('last_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                                        <div class="col-sm-9">
                                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ auth()->user()->email }}" required autocomplete="email">

                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">{{ __('Image') }}</label>
                                                        <div class="col-sm-9">
                                                            <div class="image-preview-demo">
                                                                @if (auth()->user()->image)
                                                                    <img src="{{ auth()->user()->image->getUrl() }}" alt="" class="img-fluid preview">
                                                                @else
                                                                    <img src="{{ asset('/admin_styles/img/avatar/avatar-1.png') }}" alt="" class="img-fluid preview">
                                                                @endif
                                                            </div>

                                                            <div>
                                                                <input type="hidden" name="image" class="image-data">
                                                                <input type="file" accept="image/*" class="form-control file-input @error('image') is-invalid @enderror" />
                                                            </div>
                                                            
                                                            @error('image')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <button type="submit" class="submit-edit btn btn-warning btn-block">{{ __('Submit') }}</button>
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
                    </div>
                </div>
            </div>
            </div>
        </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('/admin_styles/js/croppie.min.js') }}"></script>

    <script>
        var crop = $('.image-preview-demo img.preview').croppie({
            enableExif: true,
            enableResize: true,
            viewport: { width: 200, height: 200, type: 'square' }
        });

        $('.file-input').on('change', function(e) {
            let image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
                $('.image-preview-demo img.preview').attr('src', e.target.result)
                $('.image-preview-demo .cr-boundary').remove()
                $('.image-preview-demo .cr-slider-wrap').remove()
                var crop = $('.image-preview-demo img.preview').croppie({
                    enableExif: true,
                    enableResize: true,
                    viewport: { width: 200, height: 200, type: 'square' }
                });
            }
        })

        $('button.submit-edit').on('click', function(e) {
            e.preventDefault();
            var that = $(this);
            crop.croppie('result', 'base64').then((image_data) => {
                $("input.image-data").val(image_data);
                that.parents('form').submit();
            })
        })

    </script>
@endsection