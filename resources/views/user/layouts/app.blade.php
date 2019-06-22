<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->getLocale('ar'))
    dir="rtl"
@endif>
    @include('user.layouts.head')
<body class="common-home res layout-1">
    <div id="wrapper" class="wrapper-fluid banners-effect-5">

        @include('user.layouts.header.header')
        
        @include('user.layouts.footer')
        @include('user.layouts.js')
    </div>
</body>
</html>