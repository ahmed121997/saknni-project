@if ($property->status)
    <span class="text-success">{{ __('admin.active') }}</span>
@else
    <span class="text-danger">{{ __('admin.not_active') }}</span>
    <button class="btn btn-danger btn-sm verify" id="{{ $property->id }}">Verify</button>
@endif
