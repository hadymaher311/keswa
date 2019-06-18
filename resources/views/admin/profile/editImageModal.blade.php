<link rel="stylesheet" href="{{ asset('/admin_styles/css/cropper.css') }}">

<script src="{{ asset('/admin_styles/js/cropper.js') }}"></script>

<script>
    $(function() {
        let modal_1_body = '<form action="{{ route("admin.profile.edit.image") }}" method="post" enctype="multipart/form-data">';
        modal_1_body += '@csrf';
        modal_1_body += '@method("PUT")';
        modal_1_body += ' <div class="image-preview-demo">';
        modal_1_body += '</div>';
        modal_1_body += '<input type="hidden" name="image" class="image-data">';
        modal_1_body += '<input type="file" accept="image/*" class="form-control file-input @error("image") is-invalid @enderror" />';
        modal_1_body += '<br>';
        modal_1_body += '<button class="submit-form btn btn-warning btn-block">{{ __("Submit") }}</button>';
        modal_1_body += '</form>';
        $("#modal-1").fireModal({
          title: '{{ __("Change image") }}',
          body: modal_1_body
        });
        var $Image;
        var crop;
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
                    cropBoxMovable: false
                    });
            }
        })
        
        $('.modal').on('click', '.submit-form', function(event) {
            event.preventDefault();
            
            $(".image-data").val($Image.cropper('getCroppedCanvas').toDataURL());
            $(this).parents('form').submit();
            
            
        })
        
    })
</script>