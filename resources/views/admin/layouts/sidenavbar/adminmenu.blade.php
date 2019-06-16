<li class="dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>{{ __('Admin') }}</span></a>
    <ul class="dropdown-menu">
        @can('view admins')
            <li class="dropdown">
                <a class="nav-link has-dropdown" href="#"><i class="fa fa-users"></i>{{ __('Admins') }}</a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admins.index') }}">{{ __('Home') }}</a></li>
                    
                    @can('create admins')
                        <li><a class="nav-link" href="{{ route('admins.create') }}">{{ __('Create') }}</a></li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('view permissions')
            <li class="dropdown">
                <a class="nav-link has-dropdown" href="#"><i class="fa fa-lock"></i>{{ __('Permissions') }}</a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('permissions.index') }}">{{ __('Home') }}</a></li>
                    @can('create permissions')
                        <li><a class="nav-link" href="{{ route('permissions.create') }}">{{ __('Create') }}</a></li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('view roles')
            <li class="dropdown">
                <a class="nav-link has-dropdown" href="#"><i class="fa fa-briefcase"></i>{{ __('Roles') }}</a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('roles.index') }}">{{ __('Home') }}</a></li>
                    @can('create roles')
                        <li><a class="nav-link" href="{{ route('roles.create') }}">{{ __('Create') }}</a></li>
                    @endcan
                </ul>
            </li>
        @endcan
    </ul>
</li>