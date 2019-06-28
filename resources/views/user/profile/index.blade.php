@extends('user.layouts.app')

@section('title')
    {{ auth()->user()->name }} - {{ __('My Account') }} - {{ config('app.name') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/user_styles/css/cropper.css') }}">
@endsection

@section('body')
<!-- Main Container  -->
<div class="main-container container" style="margin-top: 4rem">

    <div class="row">
        <!--Middle Part Start-->
        <div id="content" class="col-sm-9">
            <h2 class="title">{{ __('My Account') }}</h2>
            <h3>{{ __('Hi') }}, <b>{{ auth()->user()->name }}</b></h3>
            <div class="row">
                <div class="col-sm-3 text-center" style="margin-bottom: 2rem">
                    <div class="thumbnail">
                        <img class="img-responsive img-circle" src="{{ (Auth::user()->image) ? Auth::user()->image->getUrl() : asset(config('app.default_avatar')) }}" alt="{{ auth()->user()->name }}">
                    </div>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#ImageModal">{{ __('Change image') }}</button>
                </div>
                <div class="col-sm-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ __('Personal info') }}
                            <a href="{{ route('user.info.edit') }}" class="pull-right btn btn-link"><i class="fa fa-edit"></i> {{ __('Edit info') }}</a>
                        </div>
                        <div class="panel-body">
                            <div>
                                <b>{{ __('Name') }}:</b>
                                {{ auth()->user()->name }}
                            </div>
                            <div>
                                <b>{{ __('Email') }}:</b>
                                {{ auth()->user()->email }}
                            </div>
                            <div>
                                <b>{{ __('Mobile') }}:</b>
                                {{ (auth()->user()->personalInfo) ? auth()->user()->personalInfo->phone : '' }}
                            </div>
                            <div>
                                <b>{{ __('Gender') }}:</b>
                                {{ auth()->user()->personalInfo ? __(ucfirst(auth()->user()->personalInfo->gender)) : '' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ImageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form class="image-form" action="{{ route("user.profile.edit.image") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{ __('Change image') }}</h4>
                        </div>
                        <div class="modal-body">
                            
                            <div class="image-preview-demo">
                            </div>
                            <input type="hidden" name="image" class="image-data">
                            <input type="file" accept="image/*" class="form-control file-input @error("image") is-invalid @enderror" />
                        </div>
                        <div class="modal-footer">
                            <button class="submit-form btn btn-primary">{{ __("Submit") }}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('user.components.accountSideLinks')

    </div>
</div>
<!-- //Main Container -->
@endsection

@section('js')
<script src="{{ asset('/user_styles/js/cropper.js') }}"></script>
<script>
    $(function() {
        $('.modal').on('change', '.file-input', function(e) {
            let image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
                $('.image-preview-demo').html('<img src="" alt="" class="img-fluid preview">')
                $('.image-preview-demo img.preview').attr('src', e.target.result)
                $Image = $('.image-preview-demo img.preview')
                crop = $Image.cropper({
                    aspectRatio: 1 / 1,
                    dragMode: 'move',
                    autoCropArea: 1.0,
                    });
            }
        })
        
        $('.modal').on('click', '.submit-form', function(event) {
            event.preventDefault();
            
            $(".image-data").val($Image.cropper('getCroppedCanvas').toDataURL());
            $(this).parents('form.image-form').submit();
            
            
        })
    })
</script>
@endsection
