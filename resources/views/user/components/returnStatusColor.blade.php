@php
    $status_colors = [
        'Waiting for confirmation' => 'warning',
        'Approved' => 'primary',
        'Disapproved' => 'danger',
        'In the way' => 'info',
        'Completed' => 'success',
        'Canceled' => 'danger',
        'Return denied' => 'danger',
    ];
@endphp
@if (isset($status_colors[$return_status]))
<span class="label label-{{ $status_colors[$return_status] }}">{{ __($return_status) }}</span>
@endif