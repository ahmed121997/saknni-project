@extends('layouts.app')
@section('links')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection
@section('title' , ' | '.__('messages.search'))
@section('content')

    <div class="text-center h2  welcome-message p-4 ">

        @include('search.formMainSearch', [
            'type_properties' => $type_properties,
            'type_payments' => $type_payments,
            'govs' => $govs,
        ])

    </div>
    <div class="container welcome">
        <h3 class="mt-lg-3"> <i class="fa fa-home" aria-hidden="true"></i>
            {{ __('property.property_for') }} {{ $sell_rent == 'rent' ? __('property.rent') : __('property.sell') }}
            @if ($city_name != null)
                {{ __('property.in') }} {{ $city_name->city_name }}
            @endif
        </h3>
        <hr />
        <div class="row">
            @if (isset($properties) && count($properties) > 0)
                @foreach ($properties as $property)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <x-property-card :property="$property" />
                    </div>
                @endforeach
        </div>
        <div class="d-flex justify-content-center mt-2">
        </div>
        @endif

    </div>
@endsection

@section('script')
    @include('search.scriptMainSearch')
    @include('layouts.scriptFavorite')
@endsection
