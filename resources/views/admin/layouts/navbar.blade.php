<div class="navbar-bg bg-warning"></div>
<nav class="navbar bg-warning navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right">
        <div class="dropdown-header">{{ __('Notifications') }}
          <div class="float-right">
            <a href="#">{{ __('Mark All As Read') }}</a>
          </div>
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
          <a href="#" class="dropdown-item dropdown-item-unread">
            <div class="dropdown-item-icon bg-primary text-white">
              <i class="fas fa-code"></i>
            </div>
            <div class="dropdown-item-desc">
              Template update is available now!
              <div class="time text-primary">2 Min Ago</div>
            </div>
          </a>
        </div>
        <div class="dropdown-footer text-center">
          <a href="#">{{ __('View All') }} <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li>
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="{{ (Auth::user()->image) ? Auth::user()->image->getUrl('thumb') : asset('/admin_styles/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
      <div class="d-sm-none d-lg-inline-block">{{ __('Hi') }}, {{ Auth::user()->name }}</div></a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
          <i class="far fa-user"></i> {{ __('Profile') }}
        </a>
        <a href="{{ route('admin.profile.settings') }}" class="dropdown-item has-icon">
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
      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
      </form>
    </li>
  </ul>
</nav>
