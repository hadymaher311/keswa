@if (app()->getLocale() == 'ar')
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/jquery-2.2.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/owl-carousel/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/themejs/libs.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/unveil/jquery.unveil.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/countdown/jquery.countdown.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/dcjqaccordion/jquery.dcjqaccordion.2.8.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/datetimepicker/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/modernizr/modernizr-2.6.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/minicolors/jquery.miniColors.min.js') }}"></script>

    <!-- Theme files
    ============================================ -->

    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/themejs/application.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/themejs/homepage.js') }}"></script>
    @if (Route::currentRouteName() == 'welcome')
        <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/themejs/toppanel.js') }}"></script>
    @endif
    
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/themejs/so_megamenu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/RTL/js/themejs/addtocart.js') }}"></script>
@else
    <script type="text/javascript" src="{{ asset('/user_styles/js/jquery-2.2.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/owl-carousel/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/themejs/libs.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/unveil/jquery.unveil.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/countdown/jquery.countdown.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/dcjqaccordion/jquery.dcjqaccordion.2.8.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/datetimepicker/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/modernizr/modernizr-2.6.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/minicolors/jquery.miniColors.min.js') }}"></script>

    <!-- Theme files
    ============================================ -->

    <script type="text/javascript" src="{{ asset('/user_styles/js/themejs/application.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/user_styles/js/themejs/homepage.js') }}"></script>
    @if (Route::currentRouteName() == 'welcome')
        <script type="text/javascript" src="{{ asset('/user_styles/js/themejs/toppanel.js') }}"></script>
    @endif
    <script type="text/javascript" src="{{ asset('/user_styles/js/themejs/so_megamenu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/user_styles/js/themejs/addtocart.js') }}"></script>
@endif


@yield('js')
