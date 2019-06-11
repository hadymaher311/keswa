@extends('admin.layouts.app')

@section('title')
{{ __('Edit admin') }}
@endsection

@section('css')
    
@endsection

@section('body')
    <div class="section-header">
        <h1>{{ __('Admins') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>{{ __('Edit admin') }}</h4> <br>
                    <a href="{{ route('admins.create') }}" class="btn btn-success m-3"><i class="fa fa-plus"></i> {{ __('Add new admin') }}</a>
                    <a href="{{ route('admins.index') }}" class="btn btn-primary m-3"><i class="fa fa-home"></i> {{ __('Back to all') }}</a>
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
                        {{ $error }}
                    @endforeach
                    <form action="{{ route('admins.update', $admin->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">{{ __('First Name') }}</label>
                            <div class="col-sm-9">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $admin->first_name }}" required autocomplete="first_name" autofocus>

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
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $admin->last_name }}" required autocomplete="last_name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $admin->email }}" required autocomplete="email">

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
                            <label for="inputEmail" class="col-sm-3 control-label">{{ __('Roles') }}</label>
        
                            <div class="col-sm-9">
                                <select name="role" id="role" required class="form-control @error('role') is-invalid @enderror">
                                    <option value="">{{ __('Choose admin role') }}</option>
                                    @foreach ($roles as $role)
                                        <option @if ($role->id == $admin->role)
                                            selected
                                        @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>

                                @error('role')
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