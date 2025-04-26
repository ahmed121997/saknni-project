@extends('admin.layouts.app')
@section('title', ' | Users')
@section('links')
    <!-- Custom styles for this page -->
    <link href="{{ asset('css/admin/all.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Users Data</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Users</h6>
            </div>
            <div class="card-body">
                <table id="dataTable_user" class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
                            <th>Status</th>
                            <th>Last Seen</th>
                        </tr>
                    </thead>
                    <tbody>
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
            var table = $('#dataTable_user').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.users.datatable') }}',
                    type: 'POST',
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'last_seen',
                        name: 'last_seen',
                        className: 'text-center',
                    },
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
                    url: '{{ route('admin.verify.user') }}',
                    data: {
                        'id': this.id,
                    },
                    success: function(data) {
                        table.draw();
                    },
                    error: function(reject) {

                    },
                });
            });
        });
    </script>
@endsection
