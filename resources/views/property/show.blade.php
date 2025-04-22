@extends('layouts.app')
@section('links')
<link rel="stylesheet" href="{{asset('css/showProperty.css')}}"/>
@endsection
@section('title', ' | '.@$property->des->title)
@section('content')
    <div class="container">
        <h2 class="h2">{{@$property->des->title}}</h2>
        <div class="mb-2 properties-icon">
            <span ><i class="fas fa-map-marker-alt"></i> {{$property->city->name}}</span>
            <span><i class="fas fa-building"></i> {{$property->typeProperty->name}}</span>
            <span><i class="fas fa-expand"></i> <bdi>{{$property->area}} {{__('property.m')}} <sup>2</sup></bdi></span>
            <span style="float: {{app()->getLocale() == 'en'?'right ;margin-right: 5em;':'left;margin-left:5em'}} ;font-weight: bold;font-size: large;color:#F89406">{{$property->price}} {{__('property.eg')}} @if($property->list_section == 'rent') / {{$property->type_rent}} @endif</span>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @if($property->images->count() > 0)
                    @foreach($property->images as $key => $image)
                        <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}" class="@if($key === 0) active @endif"></li>
                    @endforeach
                @endif
            </ol>
            <div class="carousel-inner" style="height: 30em;position: relative;">
                @if($property->images->count() > 0)
                    @foreach($property->images as $key =>  $image)
                        <div class="carousel-item @if($key == 0) active @endif  position-relative">
                            <img class="d-block w-100 img-thumbnail" style="height: 30em;" src="{{asset($image->source)}}" alt="First slide">
                        </div>
                    @endforeach
                @endif
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="container show-property">
            <div class="row">
                @if(isset($property))
                    <div id="{{$property->id}}" class="col-sm-12 col-md-8 mt-3 alert alert-info">
                        <div class="row">
                            <div class="col-12"><h4>{{__('property.information_about_Property')}} :</h4></div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.type_property')}} :  </span> {{@$property->typeProperty->name}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 " ><span>{{__('property.view')}} :  </span> {{@$property->view->name}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.use_for')}} :  </span> {{$property->list_section}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.floor')}} :  </span> {{$property->num_floor}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.number_of_rooms')}} :  </span> {{$property->num_rooms}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.number_of_bathrooms')}}:  </span> {{$property->num_bathroom}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.finish')}} :  </span> {{$property->finish->type}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.city')}} :  </span> {{@$property->city->name}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.type_pay')}} :  </span> {{@$property->payment->name}}</div>
                            <div class="col-xs-12 col-sm-6 col-md-4" style="color:#F89406"><span>{{__('property.price')}} :  </span > {{$property->price}} {{__('property.eg')}}@if($property->list_section == 'rent') / {{$property->type_rent}} @endif </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.link_youtube')}} :  </span><button class="btn btn-primary background-saknni"><a href="{{$property->link_youtube}}" target="_blank">Youtube link</a></button> </div>
                            <div class="col-xs-12 col-sm-6 col-md-4 "><span>{{__('property.location')}} :  </span> {{$property->location}}</div>
                            <div class="col-12"><hr/></div>
                            <div class="col-12 "><span class="text-dark font-weight-bold">{{__('property.details_property')}} :  </span>
                                <p class="text-secondary ">
                                    {{$property->des->details}}
                                </p>
                                <hr/>
                            </div>

                            {{-- start youtube --}}
                            @if($property->link_youtube != null)
                                <div class="col-12">
                                    <h4>{{__('property.video property')}} :</h4>
                                </div>
                                <div class="col-12">
                                    <iframe width="100%" height="400" src="{{ getYoutubeEmbedUrl($property->link_youtube) }}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @endif
                            {{-- end youtube --}}
                        </div>
                    </div>

                    <div class="co-sm-12 col-md-4 text-center contact mt-md-5">
                        <div >
                            <div class="mt-5 mb-3">
                                <button class="btn btn-primary w-75  show-number btn-lg background-saknni"><i class="fas fa-phone"></i>{{__('property.show_number')}}</button>
                                <a class="btn btn-primary btn-lg number-phone mb-3 background-saknni" href="tel:{{$property->user->phone}}">{{$property->user->phone}}</a>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary w-75 show-email btn-lg background-saknni"><i class="fas fa-envelope-square"></i>{{__('property.show_email')}}</button>
                                <div class="mt-4"></div>
                                <a class="btn btn-primary email btn-lg mt-3 background-saknni" href="mailto:{{$property->user->email}}">{{$property->user->email}}</a>
                            </div>

                        </div>
                    </div>

                @endif
            </div>
        </div>
        <div class="container mt-3" id="display_comment">
            <h3>{{__('property.comments')}}</h3>
            @php($comments = $property->comments()->with('user')->get())
            @foreach($comments as $comment)
                <x-comment-box :comment="$comment" />
            @endforeach
        </div>
        <div class="container">
            <hr />
            @auth()
            <h4>{{__('property.add_comment')}}</h4>
            <form class="add-comment">
                @csrf
                <div class="form-group">
                    <textarea  class="form-control" name="body" id="comment_body"></textarea>
                    <input type="hidden" name="property_id" value="{{ $property->id }}" />
                    <p class="text-danger error"></p>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success btn-add-comment background-saknni" value="{{__('property.add_comment')}}" />
                </div>
            </form>
              @else
                <div class="text-primary text-center"> {{__('property.to_add_comment')}} <a class="btn btn-sm btn-primary background-saknni" href="{{route('login')}}">{{__('property.login')}}</a></div>
            @endauth
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('js/showProperty.js')}}"></script>
    @auth()
    <script>
        $(".btn-add-comment").click(function(e){
            let property_id = $('.add-comment input[name="property_id"]')[0].value;
            let body = $('.add-comment #comment_body')[0].value;
            e.preventDefault();
            if(body  != ""){
                $('.error').show().text("");
                $.ajax({
                    type: 'post',
                    url: '{{route("comments.store")}}',
                    data: {
                        '_token' : "{{csrf_token()}}",
                        'property_id' : property_id,
                        'body' :  body,
                    },
                    success: function(data) {
                        if(data.status == true){
                            $('#display_comment ').append(data.html);
                        }
                    },
                    error: function(reject) {

                    },
                });
            }else{
                $('.error').show().text('comment body is required');
            }

        });
        </script>
    @endauth
    @include('layouts.scriptFavorite')
@endsection
