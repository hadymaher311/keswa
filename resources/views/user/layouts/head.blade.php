<head>

    <!-- Basic page needs
    ============================================ -->
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <!-- Mobile specific metas
    ============================================ -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    @if (app()->getLocale() == 'ar')
        <!-- Libs CSS
        ============================================ -->
        <link rel="stylesheet" href="{{ asset('/user_styles/RTL/css/bootstrap/css/bootstrap.rtl.min.css') }}">
        <link href="{{ asset('/user_styles/RTL/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/js/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/js/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/css/themecss/lib.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/js/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/js/minicolors/miniColors.css') }}" rel="stylesheet">
        
        <!-- Theme CSS
        ============================================ -->
        <link href="{{ asset('/user_styles/RTL/css/themecss/so_searchpro.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/css/themecss/so_megamenu.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/css/themecss/so-categories.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/css/themecss/so-listing-tabs.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/css/themecss/so-newletter-popup.css') }}" rel="stylesheet">

        <link href="{{ asset('/user_styles/RTL/css/footer/footer1.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/css/header/header1.css') }}" rel="stylesheet">
        <link id="color_scheme" href="{{ asset('/user_styles/RTL/css/theme.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/RTL/css/responsive.css') }}" rel="stylesheet">
    
    @else
        <!-- Libs CSS
        ============================================ -->
        <link rel="stylesheet" href="{{ asset('/user_styles/css/bootstrap/css/bootstrap.min.css') }}">
        <link href="{{ asset('/user_styles/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/js/datetimepicker/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/js/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/css/themecss/lib.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/js/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/js/minicolors/miniColors.css') }}" rel="stylesheet">
        
        <!-- Theme CSS
        ============================================ -->
        <link href="{{ asset('/user_styles/css/themecss/so_searchpro.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/css/themecss/so_megamenu.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/css/themecss/so-categories.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/css/themecss/so-listing-tabs.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/css/themecss/so-newletter-popup.css') }}" rel="stylesheet">

        <link href="{{ asset('/user_styles/css/footer/footer1.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/css/header/header1.css') }}" rel="stylesheet">
        <link id="color_scheme" href="{{ asset('/user_styles/css/theme.css') }}" rel="stylesheet">
        <link href="{{ asset('/user_styles/css/responsive.css') }}" rel="stylesheet">
    @endif

        <!-- Google web fonts
    ============================================ -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700' rel='stylesheet' type='text/css'>
    <style type="text/css">
            body{font-family:'Roboto', sans-serif}
    </style>

    @yield('css')

</head>