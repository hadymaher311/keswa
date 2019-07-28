<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->isLocale('ar')) dir="rtl" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('Invoice') }}</title>
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
    <style type="text/css" media="print">
        @page {
            margin: 0;  /* this affects the margin in the printer settings */
        }
        </style>
</head>
<body onload="window.print()">
    @include('admin.components.returnInvoice')
    <script src="{{ asset('/admin_styles/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/popper.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/tooltip.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('/admin_styles/modules/moment.min.js') }}"></script>
    <script src="{{ asset('/admin_styles/js/stisla.js') }}"></script>
    @yield('js')

    <!-- Template JS File -->
    <script src="{{ asset('/admin_styles/js/scripts.js') }}"></script>
</body>
</html>