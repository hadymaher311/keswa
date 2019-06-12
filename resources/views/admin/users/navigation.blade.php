<ul class="nav nav-pills flex-column">
    <li class="nav-item"><a href="{{ route('users.show', $user->id) }}" class="nav-link">{{ __('Personal info') }}</a></li>
    <li class="nav-item"><a href="#" class="nav-link">{{ __('Addresses') }}</a></li>
    <li class="nav-item"><a href="#" class="nav-link">{{ __('Orders') }}</a></li>
    <li class="nav-item"><a href="#" class="nav-link">{{ __('Cart') }}</a></li>
    <li class="nav-item"><a href="#" class="nav-link">{{ __('Wishlist') }}</a></li>
</ul>