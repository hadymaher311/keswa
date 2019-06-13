@extends('admin.layouts.app')

@section('title')
{{ __('Edit category') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/summernote/summernote-bs4.css') }}">    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Categories') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit category') }}</h4> <br>
                        <a href="{{ route('categories.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new category') }}</a>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                    <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Name') }} {{ __('in English') }}</label>
                            <div class="col-sm-9">
                                <input id="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" name="name_en" value="{{ $category->name_en }}" autocomplete="name_en" autofocus>
                                
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
                                <input id="name_ar" type="text" class="form-control @error('name_ar') is-invalid @enderror" name="name_ar" value="{{ $category->name_ar }}" autocomplete="name_ar">
                                
                                @error('name_ar')
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
                                    {!! $category->description_en !!}
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
                                        {!! $category->description_ar !!}
                                </textarea>
                                
                                @error('description_ar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('Image') }}</label>
                            <div class="col-sm-9">
                                <div id="image-preview" class="image-preview">
                                    <label for="image-upload" id="image-label">{{ __('Choose Image') }}</label>
                                    <input type="file" accept="image/*" name="image" id="image-upload" />
                                    
                                    @error('image')
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
<script src="{{ asset('/admin_styles/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>

<script>
    $.uploadPreview({
        input_field: "#image-upload",   // Default: .image-upload
        preview_box: "#image-preview",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "{{ __('Choose Image') }}",   // Default: {{ __('Choose Image') }}
        label_selected: "{{ __('Change Image') }}",  // Default: Change File
        no_label: false,                // Default: false
        success_callback: null          // Default: null
    });
</script>
@endsection