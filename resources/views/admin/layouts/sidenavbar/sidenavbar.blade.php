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
            <li><a class="nav-link" href="{{ route('admin.home') }}">{{ __('Homepage') }}</a></li>
          </ul>
        </li>

        @can('view returns')
            <li><a class="nav-link" href="{{ route('returns.index') }}"><i class="fas fa-reply"></i> <span>{{ __('Returns') }}</span></a></li>
        @endcan

        @can('view orders')
            <li><a class="nav-link" href="{{ route('orders.index') }}"><i class="fas fa-barcode"></i> <span>{{ __('Orders') }}</span></a></li>
        @endcan

        @if (auth()->user()->can('view pos_workers') || auth()->user()->can('view pos_orders'))
          @include('admin.layouts.sidenavbar.posmenu')
        @endif

        @if (auth()->user()->can('view products') || auth()->user()->can('view brands') || auth()->user()->can('view categories') || auth()->user()->can('view sub_categories') || auth()->user()->can('view warehouses'))
          @include('admin.layouts.sidenavbar.catalogmenu')
        @endif
        @if (auth()->user()->can('view users'))
          @include('admin.layouts.sidenavbar.usermenu')
        @endif
        @if (auth()->user()->can('view admins') || auth()->user()->can('view permissions') || auth()->user()->can('view roles'))
          @include('admin.layouts.sidenavbar.adminmenu')
        @endif

        @can('general settings')
          <li><a class="nav-link" href="{{ route('general.settings') }}"><i class="fas fa-pencil-ruler"></i> <span>{{ __('General Settings') }}</span></a></li>
        @endcan
      </ul>
    </aside>
  </div>
