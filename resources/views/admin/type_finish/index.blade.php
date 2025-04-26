@extends('admin.layouts.app')
@section('title', ' | Finish Types')
@section('links')
    <link href="{{ asset('css/admin/all.css') }}" rel="stylesheet">
@endsection
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-1 text-gray-800">Finish Types</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Finish Types</h6>
                <a href="#!" id="addTypeFinish" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-plus fa-sm text-white-50"></i> Add Finish Type</a>
            </div>
            <div class="card-body">
                <table id="dataTable_finish" class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @include('admin.type_finish.modals')
    <!-- /.container-fluid -->
@endsection

@section('script')
    <!-- Page level plugins -->
    <script type="text/javascript">
        $(document).ready(function() {
            // set the CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Initialize DataTable
            var table = $('#dataTable_finish').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.type-finishes.datatable') }}',
                    type: 'POST',
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
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

            // Add Type Property
            $('#addTypeFinish').on('click', function() {
                $("#finish_type_id").val('');
                $('#btnSave').html('Save');
                $('#adminForm').trigger("reset");
                $('#addModal').modal('show');
                $('#addModalLabel').html('Add Finish Type');

            });

            $('body').on('click', '.editTypeFinish', function () {
                var item_id = $(this).data('id');
                $.get("{{ route('admin.type-finishes.index') }}" +'/' + item_id +'/edit', function (data) {
                    $('#addModal').modal('show');
                    $('#addModalLabel').html('Edit Finish Type');
                    $('#finish_type_id').val(data.id);
                    let names = data.name;
                    Object.keys(names).forEach(key => {
                        $('#finishTypeName_' + key).val(names[key]);
                    });
                    $('#btnSave').html('Update');
                });
            });

            $('#btnSave').on('click', function(e) {
                e.preventDefault();
                let form_data = new FormData($('#adminForm')[0]);
                $.ajax({
                    data: form_data,
                    url: "{{ route('admin.type-finishes.store') }}",
                    type: "POST",
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data) {
                        if (data.status == true) {
                            $('#addModal').modal('hide');
                            $('#adminForm').trigger("reset");
                            table.draw();
                        }
                    },
                    error: function (xhr, status, error) {
                        let err = JSON.parse(xhr.responseText);
                        let item = err.errors;
                        $('#errors_list').empty();
                        Object.keys(item).forEach(key => {
                            console.log(item[key].join(","))
                            $('#errors_list').append(
                                "<li class='text-white'>"+item[key].join(",")+"</li>"
                            );
                            $('#danger-alert-modal').modal('show');
                        });
                    }
                });
            });

            /**
             * Delete Type Property
             */
            $('body').on('click', '.deleteTypeFinish', function() {
                var item_id = $(this).data("id");
                if (confirm('{{ __('messages.Are You sure want to delete !') }}')) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.type-finishes.store') }}" + '/' + item_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
