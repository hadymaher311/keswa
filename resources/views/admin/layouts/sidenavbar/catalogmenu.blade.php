<li class="dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-store"></i><span>{{ __('Catalog') }}</span></a>
    <ul class="dropdown-menu">
        <li class="dropdown">
            <a class="nav-link has-dropdown" href="#"><i class="fab fa-product-hunt"></i>{{ __('Products') }}</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('products.index') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('products.create') }}">{{ __('Create') }}</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="nav-link has-dropdown" href="#"><i class="fa fa-barcode"></i>{{ __('Orders') }}</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('orders.index') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('orders.create') }}">{{ __('Create') }}</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="nav-link has-dropdown" href="#"><i class="fa fa-copyright"></i>{{ __('Categories') }}</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('categories.index') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('categories.create') }}">{{ __('Create') }}</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="nav-link has-dropdown" href="#"><i class="fa fa-copyright"></i>{{ __('Sub categories') }}</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('sub_categories.index') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('sub_categories.create') }}">{{ __('Create') }}</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="nav-link has-dropdown" href="#"><i class="fa fa-ad"></i>{{ __('Brands') }}</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('brands.index') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('brands.create') }}">{{ __('Create') }}</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="nav-link has-dropdown" href="#"><i class="fa fa-warehouse"></i>{{ __('Warehouses') }}</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('warehouses.index') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('warehouses.create') }}">{{ __('Create') }}</a></li>
            </ul>
        </li>
    </ul>
</li>