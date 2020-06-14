@extends('backend.layout.app')

@section('datatable-style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Purchase Order Lists</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Purchase Order Lists</h2>
                            <a href="{{ route('purchase-create') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-plus-circle"></i> Add</a>
                            <!-- <a href="{{ route('custom-purchase-create') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-plus-circle"></i> Custom Create</a> -->
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>{{ Session::get('type') }}</strong> {{ Session::get('message') }}
                                </div>
                            @endif
                            <table class="datatable table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>PO Number</th>
                                    <th>Order Date</th>
                                    <th>Company Name</th>
                                    <th>Customer Account Number</th>
                                    <th>Total</th>
                                    <th>Discount</th>
                                    <th>Taxable Amount</th>
                                    <th>Grand Total</th>
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
                ajax: '{{ route('purchase-orders-lists') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'po_number', name: 'po_number'},
                    {data: 'order_date', name: 'order_date'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'customer_account_no', name: 'customer_account_no'},
                    {data: 'total', name: 'total'},
                    {data: 'discount', name: 'discount'},
                    {data: 'taxable', name: 'taxable'},
                    {data: 'grand_total', name: 'grand_total'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            $(document).on('click', '.deletePO', function (e) {
                if (confirm("Are you sure want to delete this purchase order?")) {
                    NProgress.start();
                    $.ajax({
                        type: 'GET',
                        url: base_url + '/purchase/destroy/' + $(this).data('id'),
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
