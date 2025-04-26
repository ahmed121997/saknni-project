@extends('admin.layouts.app')
@section('title', ' | Edit Profile')
@section('links')
    <link href="{{ asset('css/admin/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('users.update_your_profile') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.profile.update', $user->id) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-center">{{ __('users.name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $user->name }}" required autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-center">{{ __('users.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $user->email }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mobile"
                                    class="col-md-4 col-form-label text-md-center">{{ __('users.phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ $user->phone }}" required autocomplete="phone">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPhoto" class="col-form-label col-md-4 text-md-center">Image</label>
                                <div class="col-6">
                                    <div class="input-group text-md-center">
                                        <span class="input-group-btn">
                                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                            <i class="fa fa-picture-o text-white"></i> Choose
                                            </a>
                                        </span>
                                    <input id="thumbnail" class="form-control" type="text" name="image" value="{{$user->image}}">
                                  </div>
                                  <div id="holder" style="margin-top:15px;max-height:100px;">
                                    @if ($user->image)
                                        <img src="{{ asset($user->image) }}" style="height: 100px; width: 100px;">
                                    @endif
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0 text-end">
                                <div class="col-md-6 offset-md-8">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('js/admin/all.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#lfm').filemanager('image', {
                prefix: '/admin/media-filemanager'
            });
        });
    </script>
@endsection

