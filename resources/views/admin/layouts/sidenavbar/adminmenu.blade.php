<li class="dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>{{ __('Admin') }}</span></a>
    <ul class="dropdown-menu">
        <li class="dropdown">
            <a class="nav-link has-dropdown" href="#"><i class="fa fa-lock"></i>{{ __('Permissions') }}</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('permissions.index') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('permissions.create') }}">{{ __('Create') }}</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="nav-link has-dropdown" href="#"><i class="fa fa-briefcase"></i>{{ __('Roles') }}</a>
            <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('roles.index') }}">{{ __('Home') }}</a></li>
                <li><a class="nav-link" href="{{ route('roles.create') }}">{{ __('Create') }}</a></li>
            </ul>
        </li>
    </ul>
</li>