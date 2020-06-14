@extends('backend.layout.app')

@section('datatable-style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Organizations</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>organizations Lists</h2>
                            @if($organizationCount===0)
                                <a href="{{ route('organizations-add') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-plus-circle"></i> Add</a>
                            @endif;
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="datatable table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Owner Name</th>
                                    <th>Organization Code</th>
                                    <th>Pan No</th>
                                    <th>GSTIN No</th>
                                    <th>Registration No</th>
                                    <th>Is Default</th>
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
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('organizations-lists') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'owner_name', name: 'owner_name'},
                    {data: 'organization_code', name: 'organization_code'},
                    {data: 'pan_no', name: 'pan_no'},
                    {data: 'gstin_no', name: 'gstin_no'},
                    {data: 'registration_no', name: 'registration_no'},
                    {data: 'is_default', name: 'is_default'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endsection
