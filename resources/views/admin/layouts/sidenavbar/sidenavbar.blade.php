<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{ url('/') }}">{{ config('app.name') }}</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
          <a href="{{ url('/') }}">{{ config('app.name') }}</a>
      </div>
      <ul class="sidebar-menu">
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>{{ __('Dashboard') }}</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('admin.home') }}">{{ __('Home') }}</a></li>
          </ul>
        </li>
        @role ('super')
          @include('admin.layouts.sidenavbar.catalogmenu')
          @include('admin.layouts.sidenavbar.adminmenu')
          @include('admin.layouts.sidenavbar.usermenu')
        @endrole
      </ul>
    </aside>
  </div>
