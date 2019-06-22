<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (app()->getLocale() == 'ar')
    dir="rtl"
@endif>
    @include('user.layouts.head')
<body class="@if (Request::is('/'))
    common-home
@endif res layout-1 layout-subpage">
    <div id="wrapper" class="wrapper-fluid banners-effect-5">

        @include('user.layouts.header.header')
        
        @section('body')
            
        @show

        @include('user.layouts.footer')
        @include('user.layouts.js')
    </div>
</body>
</html>