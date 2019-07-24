@php
    $status_colors = [
        'Waiting for confirmation' => 'warning',
        'Approved' => 'primary',
        'Disapproved' => 'danger',
        'Shipped' => 'info',
        'Completed' => 'success',
        'Canceled' => 'danger',
        'Shipping returned' => 'danger',
    ];
@endphp

<span class="badge badge-{{ (isset($status_colors[$order_status])) ? $status_colors[$order_status] : 'primary' }}">{{ __($order_status) }}</span>