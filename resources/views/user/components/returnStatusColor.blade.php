@php
    $status_colors = [
        'Waiting for confirmation' => 'primary',
        'Approved' => 'primary',
        'In the way' => 'info',
        'Completed' => 'success',
        'Canceled' => 'danger',
        'Return Denied' => 'danger',
    ];
@endphp
@if (isset($status_colors[$return_status]))
<span class="label label-{{ $status_colors[$return_status] }}">{{ __($return_status) }}</span>
@endif