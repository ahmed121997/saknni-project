<link href="{{ asset('css/showAllProperty.css') }}" rel="stylesheet">
@forelse($properties as $property)
<div class="col-md-6 col-lg-4">
    <x-property-card :property="$property" />
</div>
@empty
<div class="col-md-12">
    <div class="alert alert-danger text-center">
        <h4 class="alert-heading mt-2 text-muted">{{ __('property.no_properties_found') }}</h4>
    </div>
</div>
@endforelse

