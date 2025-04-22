@extends('layouts.app')
@section('links')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endsection
@section('title', ' | '.__('messages.home'))
@section('content')
    <div class="text-center h2  welcome-message p-4 ">
        Welcome in <span>Saknni</span> to <span>buy</span>, <span>rent</span> and <span>sell</span> properties

       @include('search.formMainSearch',['type_properties'=>$type_properties,'type_payments'=>$type_payments,'govs'=>$govs])

    </div>
    <div class="container welcome">
        <h3 class="mt-lg-3"> <i class="fa fa-home" aria-hidden="true"></i> {{__('property.special_properties')}}</h3>
        <hr/>
        <div class="row">
            @if(isset($properties) && count($properties) > 0)
                @foreach($properties as $property)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <x-property-card :property="$property" />
                    </div>
                @endforeach
            </div>
        <div class="d-flex justify-content-center mt-2">
            <button class="btn btn-secondary background-saknni"><a href="{{route('all.special.properties')}}" target="_blank">{{__('property.show_more_special_properties')}}</a></button>
        </div>
        @endif

    </div>
@endsection
@section('script')

    @include('search.scriptMainSearch')

    @include('layouts.scriptFavorite')

@endsection
