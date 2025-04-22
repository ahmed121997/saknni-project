@if ($user->email_verified_at == null)
<span class="text-danger">{{ $user->status }}
    <button class="btn btn-danger btn-sm verify"
        id="{{ $user->id }}">{{ __('admin.verify') }}</button>
</span>
@else
<span class="text-success">{{ __('admin.verified') }}</span>
@endif
