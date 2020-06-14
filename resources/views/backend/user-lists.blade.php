@extends('backend.layout.app')

@section('datatable-style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Users</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Users Lists</h2>
                            @if($auth->role !== 'Agent')
                            <a href="{{ route('users-add') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-plus-circle"></i> Add</a>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="datatable table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('datatable-script')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            let table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users-lists') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            $(document).on('click', '.userDelete', function (e) {
                if (confirm("Are you sure want to delete this user?")) {
                    NProgress.start();
                    $.ajax({
                        type: 'GET',
                        url: base_url + '/users/delete/' + $(this).data('id'),
                        data: {},
                        dataType: "json",
                        success: function (resultData) {
                            if (resultData) {
                                console.log(resultData);
                                table.ajax.reload();
                            }
                            NProgress.done();
                        }
                    });
                }
            });
        });
    </script>
@endsection
