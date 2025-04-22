@extends('layouts.app')
@section('links')
    <link href="{{ asset('css/showAllProperty.css') }}" rel="stylesheet">
@endsection
@section('title', ' | '.__('messages.special properties'))
@section('content')
    <div class="container">
        <h3 class="mt-lg-3"> <i class="fa fa-home" aria-hidden="true"></i> {{__('property.special_properties')}}</h3>
        <hr/>
        <div class="row">
            @if(isset($properties) && count($properties) > 0)
                @foreach($properties as $property)
                    <div class="col-md-6 col-lg-4">
                        <x-property-card :property="$property" />
                    </div>
                @endforeach
            @endif
        </div>
        <div class="d-flex justify-content-center mt-2">{{$properties->links()}}</div>
    </div>
@endsection
@section('script')
    @include('layouts.scriptFavorite')
@endsection
