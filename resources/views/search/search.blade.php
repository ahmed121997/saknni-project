@extends('layouts.app')
@section('links')
    <link rel="stylesheet" href="{{asset('css/search.css')}}"/>
@endsection
@section('title', ' | '.__('messages.search'))
@section('content')
    <div class="container-fluid search">
        <div class="row h-100">
            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2 control background-saknni h-100 pt-5 pb-5">
                <h3>{{__('property.search_control')}}</h3>
                <hr/>
                <form id="search-form">
                    @csrf
                    <label>{{__('property.gov')}}:</label>
                    <select id="gov" class="custom-select input-search" name="gov">
                        <option value="" selected>Open this select menu</option>
                        @if(isset($govs) && count($govs) > 0)
                            @foreach($govs as $gov)
                                <option value="{{$gov->id}}">{{$gov->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr/>
                    <label class="city-label none">{{__('property.city')}}:</label>
                    <select id="city" class="custom-select input-search none" name="city">
                        <option value="" selected>Open this select menu</option>
                        <optgroup label="cities">

                        </optgroup>
                    </select>
                    <hr class="none"/>
                    <label>{{__('property.type_property')}}:</label>
                    <select id="type_property" class="custom-select input-search" name="type_property">
                        <option value="" selected>Open this select menu</option>
                        @if(isset($type_properties) && count($type_properties) > 0)
                            @foreach($type_properties as $type_property)
                                <option value="{{$type_property->id}}">{{$type_property->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr/>

                    <label>{{__('property.finish')}}:</label>
                    <select class="custom-select input-search" name="type_finish">
                        <option value="" selected>Open this select menu</option>
                        @if(isset($type_finishes) && count($type_finishes) > 0)
                            @foreach($type_finishes as $type_finish)
                                <option value="{{$type_finish->id}}">{{$type_finish->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr/>
                    <label>{{__('property.type_pay')}}:</label>
                    <select class="custom-select input-search" name="type_payment">
                        <option value="" selected>Open this select menu</option>
                        @if(isset($type_payments) && count($type_payments) > 0)
                            @foreach($type_payments as $type_payment)
                                <option value="{{$type_payment->id}}">{{$type_payment->name}}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr/>
                    <div class="text-center"><button id="search" class="btn btn-secondary mb-2 background-saknni">{{__('property.search')}}</button></div>
                </form>
            </div>
            <div class="col-sm-6 col-md-8 col-lg-9 col-xl-10 results">
                <h3 class="h3 mb-0 text-gray-800 mt-2">{{__('property.results')}}</h3>
                <hr/>
                <div class="row">
                    <div class="lds-ripple"><div></div><div></div></div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>
        $("#search").click(function(e){
            e.preventDefault();
            let data = new FormData($('#search-form')[0]);
            $.ajax({
                type: 'post',
                url: '{{route("process.search")}}',
                data: data,
                processData:false,
                contentType:false,
                beforeSend: function() {
                    $(".lds-ripple").show();
                },
                success: function(data) {
                    $('.results .row').html(data.html);
                },
                error: function(reject) {

                },
            });
        });
    </script>
    <script>
        $("#gov").change(function(){
            $.ajax({
                type: 'post',
                url: '{{route("get.cities")}}',
                data: {
                    '_token' : '{{csrf_token()}}',
                    'id' : this.value,
                },
                success: function(data) {
                    let all_opt = "";
                    $.each(data,function (key,value) {
                        all_opt += " <option value=" + value.id+ ">" + value.name + "</option> ";
                    });
                    $('.none').show();
                    $("#city > optgroup").html(all_opt);
                },
                error: function(reject) {

                },
            });
        });

    </script>

    @include('layouts.scriptFavorite', [
        'jsToggle' => true,
    ])

@endsection
