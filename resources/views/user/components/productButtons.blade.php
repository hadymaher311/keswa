<form action="{{ route('user.cart.store', $product_id) }}" method="post">
    @csrf
    <button type="submit" class="addToCart btn-button" title="{{ __('Add to cart') }}">  <i class="fa fa-shopping-basket"></i>
        <span>{{ __('Add to cart') }} </span>
    </button>
</form>
<form action="{{ route('user.wishlist.store', $product_id) }}" method="post">
    @csrf
    <button type="submit" class="wishlist btn-button" title="{{ __('Add to WishList') }}"><i class="fa fa-heart"></i><span>{{ __('Add to WishList') }}</span>
</form>
</button>