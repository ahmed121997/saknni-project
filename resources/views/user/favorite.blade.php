@extends('layouts.app')
@section('links')

<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

@endsection
@section('title', ' | '.__('property.favorite_properties'))
@section('content')
<div class="container welcome">
    <h3 class="mt-lg-3"> <i class="fa fa-home" aria-hidden="true"></i> {{__('property.favorite_properties')}}</h3>
    <hr/>
    <div class="row">
        @if(isset($properties) && count($properties) > 0)
            @foreach($properties as $property)
                <div class="col-md-6 col-lg-4 mb-4">
                    <x-property-card :property="$property" />
                </div>
            @endforeach
        </div>

    @endif

</div>
@endsection
@section('script')

@include('layouts.scriptFavorite')
@endsection
