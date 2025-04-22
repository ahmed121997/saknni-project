<div class="card mb-3" style="max-width: 30rem;max-height: 30em;min-height: 30em">
    <img style="height: 14em" src="{{ @$property->images->first()->source }}" class="card-img-top img-thumbnail" alt="img">
    <div class="ml-2 mt-2 properties-icon">
        <span><i class="fas fa-map-marker-alt"></i> {{ $property->city->name }}</span>
        <span><i class="fas fa-building"></i> {{ $property->typeProperty->name }}</span>
        <span><i class="fas fa-expand"></i> <bdi>{{ $property->area }} {{ __('property.m') }} <sup>2</sup></bdi></span>
    </div>
    <div class="card-body">
        <h5 class="card-title">{{ @$property->des->title }}</h5>
        <div class="row" style="height: 110px">
            <p class="card-text col-6"><span>{{ __('property.finish') }} :</span> {{ $property->finish->name }}</p>
            <p class="card-text col-6"><span>{{ __('property.rooms') }} :</span> {{ $property->num_rooms }}</p>
            <p class="card-text col-6"><span>{{ __('property.price') }} :</span> {{ $property->price }}</p>
            <p class="card-text col-6"><span>{{ __('property.view') }} :</span> {{ $property->view->name }}</p>
        </div>

        <a href="{{ route('show.property', $property->id) }}" class="btn btn-primary background-saknni" target="_blank">
            {{ __('property.show_details') }}
        </a>

        @include('property.favorite', ['id' => $property->id, 'fav' => $property->isFavorited()])
    </div>
</div>
