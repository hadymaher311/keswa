<ul class="nav nav-pills flex-column">
    <li class="nav-item"><a href="{{ route('pos.profile') }}" class="nav-link">{{ __('Personal info') }}</a></li>
    <li class="nav-item"><a href="{{ route('pos.profile.edit') }}" class="nav-link">{{ __('Edit info') }}</a></li>
    <li class="nav-item"><a href="{{ route('pos.profile.address.edit') }}" class="nav-link">{{ __('Edit Address') }}</a></li>
    <li class="nav-item"><a href="{{ route('pos.profile.edit.password') }}" class="nav-link">{{ __('Change password') }}</a></li>
    <li class="nav-item"><a href="{{ route('pos.profile.settings') }}" class="nav-link">{{ __('Settings') }}</a></li>
</ul>