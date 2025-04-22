@php
    $mins = Carbon\Carbon::now()->diffInMinutes($user->last_seen);
    $mins = round(abs($mins));
@endphp
@if ($user->last_seen != null && $mins < 2)
    <span class="text-success text-center">{{ __('admin.online') }}</span>
@elseif($user->last_seen != null)
    <span class="text-success text-center">{{ Carbon\Carbon::parse($user->last_seen)->format('Y-m-d h:i a') }}</span>
@else
    <span class="text-danger text-center">Offline</span>
@endif
