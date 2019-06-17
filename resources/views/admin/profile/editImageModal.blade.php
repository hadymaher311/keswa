<link rel="stylesheet" href="{{ asset('/admin_styles/css/croppie.css') }}">
<style>
    .croppie-container .cr-image {
        position: relative;
        max-width: 100%;
    }
</style>
<script src="{{ asset('/admin_styles/js/croppie.min.js') }}"></script>

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
        modal_1_body += '<button type="submit" class="submit-form btn btn-warning btn-block">{{ __("Submit") }}</button>';
        modal_1_body += '</form>';
        $("#modal-1").fireModal({
          title: '{{ __("Change image") }}',
          body: modal_1_body
        });
        
        $('.modal').on('change', '.file-input', function(e) {
            let image = e.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = e => {
                $('.image-preview-demo .cr-boundary').remove()
                $('.image-preview-demo .cr-slider-wrap').remove()
                $('.image-preview-demo').html('<img src="" alt="" class="img-fluid preview">')
                $('.image-preview-demo img.preview').attr('src', e.target.result)
                crop = $('.image-preview-demo img.preview').croppie({
                    enableExif: true,
                    enableResize: true,
                    viewport: { width: 200, height: 200, type: 'square' }
                });
            }
        })
        
        $('.modal').on('click', '.submit-form', function(e) {
            e.preventDefault();
            var that = $(this);
            crop.croppie('result', 'base64').then((image_data) => {
                $("input.image-data").val(image_data);
                that.parents('form').submit();
            })
        })
        
    })
</script>