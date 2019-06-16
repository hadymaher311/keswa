<li class="dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-user"></i><span>{{ __('Users') }}</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="{{ route('users.index') }}">{{ __('Home') }}</a></li>
        @can('create users')
            <li><a class="nav-link" href="{{ route('users.create') }}">{{ __('Create') }}</a></li>
        @endcan
    </ul>
</li>