@if ($activeDiscount)
    <span class="price-old">{{ $price }} {{ __('LE') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
    @if ($activeDiscount->type == 'value')
        <span class="price-new">{{ $price - $activeDiscount->amount }} {{ __('LE') }}</span>
    @elseif ($activeDiscount->type == 'percentage')
        <span class="price-new">{{ ceil($price * (100 - $activeDiscount->amount) / 100) }} {{ __('LE') }}</span>
    @endif
@else
    <span>{{ $price }} {{ __('LE') }}</span>
@endif