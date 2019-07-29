<div class="navbar-bg bg-dark"></div>
<nav class="navbar bg-dark navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="{{ (Auth::user()->image) ? Auth::user()->image->getUrl('thumb') : asset(config('app.default_avatar')) }}" class="rounded-circle mr-1">
      <div class="d-sm-none d-lg-inline-block">{{ __('Hi') }}, {{ Auth::user()->name }}</div></a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ route('pos.profile') }}" class="dropdown-item has-icon">
          <i class="far fa-user"></i> {{ __('Profile') }}
        </a>
        <a href="{{ route('pos.profile.settings') }}" class="dropdown-item has-icon">
          <i class="fas fa-cog"></i> {{ __('Settings') }}
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item has-icon text-danger"
          onclick="event.preventDefault();
          document.getElementById('logout-form').submit();"
        >
          <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
        </a>
      </div>
      <form id="logout-form" action="{{ route('pos.logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
    </li>
  </ul>
</nav>
