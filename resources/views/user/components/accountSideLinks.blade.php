<!--Middle Part End-->
<aside class="col-sm-3 hidden-xs" id="column-right">
    <h2 class="subtitle">{{ __('Account') }}</h2>
    <div class="list-group">
        <ul class="list-item nav nav-pills nav-stacked">
            <li><a href="{{ route('user.profile') }}">{{ __('Profile') }}</a>
            </li>
            <li><a href="{{ route('user.cart') }}">{{ __('Cart') }}</a>
            </li>
            <li><a href="{{ route('user.wishlist') }}">{{ __('WishList') }}</a>
            </li>
            <li><a href="{{ route('user.addresses') }}">{{ __('Address Book') }}</a>
            </li>
            <li><a href="{{ route('user.reviews') }}">{{ __('Reviews') }}</a>
            </li>
            <li><a href="{{ route('user.orders') }}">{{ __('Order History') }}</a>
            </li>
            <li><a href="#">{{ __('Reward Points') }}</a>
            </li>
            <li><a href="{{ route('user.returns') }}">{{ __('Returns') }}</a>
            </li>
        </ul>
    </div>
</aside>