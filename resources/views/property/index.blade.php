@extends('layouts.app')
@section('links')

    <link href="{{ asset('css/showAllProperty.css') }}" rel="stylesheet">
@endsection
@section('title', ' | '.__('messages.all properties'))
@section('content')
    <div class="container">
        <div class="row">
            @if(isset($properties) && count($properties) > 0)
                @foreach($properties as $property)
                    <div class="col-md-6 col-lg-4  mb-4">
                        <x-property-card :property="$property" />
                    </div>
                @endforeach
        </div>
        <div class="d-flex justify-content-center mt-2">{{$properties->links()}}</div>
        @endif
    </div>
@endsection
@section('script')

    @include('layouts.scriptFavorite')

@endsection
