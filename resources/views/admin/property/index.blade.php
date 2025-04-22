@extends('admin.layouts.app')
@section('links')
    <!-- Custom styles for this page -->
    <link href="{{ asset('css/admin/all.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Properties Data</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Properties</h6>
            </div>
            <div class="card-body">
                <table id="dataTable_property" class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Title</th>
                            <th>Type</th>
                            <th>Area</th>
                            <th>Price</th>
                            <th># Rooms</th>
                            <th>Status</th>
                            <th>Special</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('js/addProperty.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // set the CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Initialize DataTable
            var table = $('#dataTable_property').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.properties.datatable') }}',
                    type: 'POST',
                },
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'area',
                        name: 'area'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'num_rooms',
                        name: 'num_rooms'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'special',
                        name: 'special',
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            });

            // Verify user
            $(document).on('click', '.verify', function(e) {
                if (!confirm('Are you sure you want to verify this user?')) {
                    return false;
                }
                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.verify.property') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': $(this).attr('id'),
                    },
                    success: function(data) {
                        table.draw();
                    },
                    error: function(reject) {

                    },
                });
            });
            $(document).on('click', '.check_special', function(e) {
                if (!confirm('Are you sure you want to change this property to special?')) {
                    return false;
                }
                var id = $(this).data('id');
                var val = $(this).is(':checked') ? 1 : 0;
                updateSpecialProperty(id, val);
            });
            function updateSpecialProperty(id, val) {
                $.ajax({
                    type: 'post',
                    url: '{{ route('admin.update.special.property') }}',
                    data: {
                        'id': id,
                        'is_special': val,
                    },
                    success: function(data) {
                        table.draw();
                    },
                    error: function(reject) {
                        console.log(reject);
                    },
                });
            }
        });
    </script>
@endsection
