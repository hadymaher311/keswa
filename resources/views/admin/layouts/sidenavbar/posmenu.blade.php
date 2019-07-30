<li class="dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i><span>{{ __('Point of sales') }}</span></a>
    <ul class="dropdown-menu">
        
        @can('view pos_workers')
            <li class="dropdown">
                <a class="nav-link has-dropdown" href="#"><i class="fas fa-user-tie"></i>{{ __('Workers') }}</a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('workers.index') }}">{{ __('Homepage') }}</a></li>
                    @can('create pos_workers')
                        <li><a class="nav-link" href="{{ route('workers.create') }}">{{ __('Create') }}</a></li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('view pos_orders')
            <li><a class="nav-link" href="{{ route('admin.pos_orders.index') }}"><i class="fas fa-barcode"></i> <span>{{ __('Orders') }}</span></a></li>
        @endcan

    </ul>
</li>