@php
    $status_colors = [
        'Waiting for confirmation' => 'warning',
        'Approved' => 'primary',
        'Shipped' => 'info',
        'Completed' => 'success',
        'Canceled' => 'danger',
    ];
@endphp

<span class="badge badge-{{ $status_colors[$order_status] }}">{{ __($order_status) }}</span>