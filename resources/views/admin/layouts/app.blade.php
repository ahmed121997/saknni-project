<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset('logo.jpg')}}"/>

    <title>{{ config('app.name', 'Laravel')  }}  @yield('title')</title>

    <!-- Custom fonts for this template -->

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/admin/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/admin/all.css')}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    @yield('links')
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

@include('admin.layouts.slidbar')

<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

        @include('admin.layouts.navbar')

        @yield('content')

        </div>
        <!-- End of Main Content -->

        @include('admin.layouts.footer')

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

{{-- @if (Session::has('success_update'))
<div class="message text-success"><i class="fa fa-check-circle" aria-hidden="true"></i>{{ Session::get('success_update') }}</div>
@endif
@if (Session::has('message'))
<div class="message text-success"><i class="fa fa-check-circle" aria-hidden="true"></i>{{ Session::get('message') }}</div>
@endif --}}
<x-session-message />
<x-danger-alert-modal />

<!-- Bootstrap core JavaScript-->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('/js/admin/sb-admin-2.min.js')}}"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
{{-- buttons --}}
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function(){
        function show_message(message, type){
            $(`.message_${type}`).removeClass('d-none').addClass('d-block').find('.message_text').text(message);
           setTimeout(function(){
                $(`.message_${type}`).removeClass('d-block').addClass('d-none');
           }, 5000);
        }
        @if(Session::has('success'))
            show_message("{{ Session::get('success') }}", 'success');
        @endif
        @if(Session::has('message'))
            show_message("{{ Session::get('message') }}", 'success');
        @endif
        @if(Session::has('error'))
            show_message("{{ Session::get('error') }}", 'error');
        @endif
        @if(Session::has('warning'))
            show_message("{{ Session::get('warning') }}", 'warning');
        @endif
    });
</script>
@yield('script')
@stack('scripts')

</body>
</html>
