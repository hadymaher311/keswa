@extends('admin.layouts.app')

@section('title')
{{ __('Add new sub sub category') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('/admin_styles/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Sub sub categories') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Add new sub sub category') }}</h4> <br>
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
                    <form action="{{ route('sub_sub_categories.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
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
                            <label for="inputEmail" class="col-sm-3 control-label">{{ __('Sub categories') }}</label>
        
                            <div class="col-sm-9">
                                <select name="category" id="category" required class="form-control @error('category') is-invalid @enderror">
                                    <option value="">{{ __('Choose category') }}</option>
                                    @foreach ($sub_categories as $category)
                                        <option @if ($category->id == old('category'))
                                            selected
                                        @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                @error('category')
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