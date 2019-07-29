<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{ url('/') }}">{{ config('app.name') }}</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
          <a href="{{ url('/') }}">{{ config('app.name') }}</a>
      </div>
      <ul class="sidebar-menu">
        <li><a class="nav-link" href="{{ route('pos.home') }}"><i class="fas fa-barcode"></i> <span>{{ __('Orders') }}</span></a></li>
      </ul>
    </aside>
  </div>
