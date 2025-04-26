@extends('admin.layouts.app')
@section('title', ' | Profile')
@section('links')
    <link href="{{ asset('css/admin/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container">
        @if (Session::has('success_update'))
            <div class="message text-success"><i class="fa fa-check-circle" aria-hidden="true"></i>
                {{ Session::get('success_update') }}</div>
        @endif
        @if (Session::has('message'))
            <div class="message text-success"><i class="fa fa-check-circle" aria-hidden="true"></i>
                {{ Session::get('message') }}</div>
        @endif
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne">
                            {{ __('users.personal_information') }}
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div><span>{{ __('users.name') }} : </span> {{ Auth::guard('admin')->user()->name }}</div>
                        <div><span>{{ __('users.email') }} : </span> {{ Auth::guard('admin')->user()->email }}</div>
                        <div><span>{{ __('users.phone') }} : </span> {{ Auth::guard('admin')->user()->phone }}</div>
                        <div><span>{{ __('users.last_edit') }} : </span> {{ Auth::guard('admin')->user()->updated_at }}
                        </div>

                        <button class="btn btn-primary  d-block ml-auto mt-3"><a
                                href="{{ route('admin.profile.edit') }}">Edit</a></button>
                    </div>
                </div>
            </div>
        </div>
        <!-------- end accordion--------------->


    </div>
@endsection

@section('script')
    <script src="{{ asset('js/admin/all.js') }}"></script>
@endsection
