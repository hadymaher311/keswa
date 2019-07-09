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
  
    @yield('css')
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('/admin_styles/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin_styles/css/components.css') }}">
    
    @if (app()->isLocale('ar'))
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/admin_styles/css/style-ar.css') }}">
      <style>
        *{
          font-family: 'Cairo', sans-serif;
        }
        .img-circle {
          border-radius: 100%;
        }
      </style>
    @endif


</head>
