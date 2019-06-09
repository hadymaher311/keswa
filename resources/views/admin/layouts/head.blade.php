<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> 
        @auth
          @if ( count(Auth::user()->unreadNotifications) )
            {{ count(Auth::user()->unreadNotifications) }}
          @endif
        @endauth
      @yield('title')
    </title>
  
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin_styles/modules/fontawesome/css/all.min.css') }}">
  
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('/admin_styles/modules/bootstrap-social/bootstrap-social.css') }}">
  
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('/admin_styles/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin_styles/css/components.css') }}">


    @yield('css')

</head>
