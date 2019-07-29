@php
    $status_colors = [
        'Waiting for confirmation' => 'warning',
        'Completed' => 'success',
    ];
@endphp

<span class="badge badge-{{ (isset($status_colors[$order_status])) ? $status_colors[$order_status] : 'primary' }}">{{ __($order_status) }}</span>