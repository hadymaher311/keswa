<!-- General JS Scripts -->
<script src="{{ asset('/admin_styles/modules/jquery.min.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/popper.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/tooltip.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('/admin_styles/modules/moment.min.js') }}"></script>
<script src="{{ asset('/admin_styles/js/stisla.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('/admin_styles/js/scripts.js') }}"></script>

<script>
    $(function(){
        $('a').each(function(){
            var $this = $(this);
            // if the current path is like this link, make it active
            if($this.attr('href') == window.location){
                $this.addClass('active');
                $this.parents('li').addClass('active');
            }
        })
    })
</script>

@yield('js')
