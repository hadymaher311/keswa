@php
    $status_colors = [
        'Waiting for confirmation' => 'warning',
        'Approved' => 'primary',
        'Disapproved' => 'danger',
        'In the way' => 'info',
        'Completed' => 'success',
        'Completed scrapped' => 'dark',
        'Canceled' => 'danger',
        'Return denied' => 'danger',
    ];
@endphp

<span class="badge badge-{{ (isset($status_colors[$return_status])) ? $status_colors[$return_status] : 'primary' }}">{{ __($return_status) }}</span>