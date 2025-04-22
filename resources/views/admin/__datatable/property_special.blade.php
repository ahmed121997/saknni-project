<div class="form-check form-switch">
    <input class="form-check-input check_special" type="checkbox" role="switch" data-id="{{ $property->id }}" id="flexSwitchCheckDefault_{{ $property->id }}" {{ $property->is_special ? 'checked' : '' }}>
    <label class="form-check-label {{ $property->is_special ? 'text-success' : 'text-danger' }}" for="flexSwitchCheckDefault_{{ $property->id }}">Special</label>
</div>
