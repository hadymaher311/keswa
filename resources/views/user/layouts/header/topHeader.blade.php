<!-- Header Top -->
<div class="header-top hidden-compact">
    <div class="container">
        <div class="row">

            <div class="header-top-left col-lg-7 col-md-8 col-sm-6 col-xs-4">
                <div class="hidden-sm hidden-xs welcome-msg"><b>{{ __('Welcome to') }} {{ config('app.name') }} !</b></div>
                @guest
                    <ul class="top-link list-inline hidden-lg hidden-md">
                        <li class="account" id="my_account">
                            <a href="#" title="My Account " class="btn-xs dropdown-toggle" data-toggle="dropdown"> <span class="hidden-xs">{{ __('My Account') }} </span>  <span class="fa fa-caret-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('register') }}"><i class="fa fa-user"></i> {{ __('Register') }}</a></li>
                                <li><a href="{{ route('login') }}"><i class="fa fa-pencil-square-o"></i> {{ __('Login') }}</a></li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="top-link list-inline hidden-lg hidden-md">
                        <li class="account" id="my_account">
                            <a href="#" title="My Account " class="btn-xs dropdown-toggle" data-toggle="dropdown"> <span class="hidden-md">{{ auth()->user()->name }} </span>  <span class="fa fa-caret-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-user"></i> {{ __('Profile') }}</a></li>
                                <li>
                                    <a style="color: red" href="{{ route('logout', app()->getLocale()) }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                        <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                                    </a>

                                </li>
                            </ul>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </div>

            <div class="header-top-right collapsed-block col-lg-5 col-md-4 col-sm-6 col-xs-8">
                <ul class="top-link list-inline lang-curr">
                    <li class="language">
                        <div class="btn-group languages-block ">
                            <form action="index.html" method="post" enctype="multipart/form-data" id="bt-language">
                                <a class="btn btn-link dropdown-toggle" data-toggle="dropdown">
                                    @if (app()->isLocale('ar'))
                                        <span class="">{{ __('Arabic') }}</span>
                                    @else
                                        <span class="">{{ __('English') }}</span>
                                    @endif
                                    <span class="fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route(Route::currentRouteName(), ['locale' => 'en']) }}">{{ __('English') }}</a></li>
                                    <li><a href="{{ route(Route::currentRouteName(), ['locale' => 'ar']) }}">{{ __('Arabic') }}</a></li>
                                </ul>
                            </form>
                        </div>
                        
                    </li>
                </ul>
            </div>
            
        </div>
    </div>
</div>
<!-- //Header Top -->