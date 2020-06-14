@extends('backend.layout.app')

@section('datatable-style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Invoice Lists</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        @if(Session::has('message'))
                            <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade in">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>{{ Session::get('type') }}</strong> {{ Session::get('message') }}
                            </div>
                        @endif
                        <div class="x_title">
                            <h2>Invoice Lists</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="datatable table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order Date</th>
                                    <th>PO Number</th>
                                    <th>Company Name</th>
                                    <th>Due Date</th>
                                    <th>Grand Total</th>
                                    <th>Paid Amount</th>
                                    <th>Due Amount</th>
                                    <th>Paid At</th>
                                    <th>Payment Remarks</th>
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
    <!-- Modal -->
    <div id="payAmount" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Pay Amount</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('payments-store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Account Number <b class="red">*</b></label>
                                    <input type="text" class="form-control" placeholder="Amount" name="amount">
                                    <input type="hidden" name="invoice_id" id="invoice_id" class="invoice_id">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Payment Mode <b class="red">*</b></label>
                                    <select name="mode" class="form-control" id="mode">
                                        <option value="">Select</option>
                                        <option value="CASH" selected>CASH</option>
                                        <option value="CHEQUE">CHEQUE</option>
                                        <option value="TRANSFER">TRANSFER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Payment Remarks <b class="red">*</b></label>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <textarea name="payment_remarks" class="form-control" id="payment_remarks"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success">Done</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                ajax: '{{ route('payments-lists') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'order_date', name: 'order_date'},
                    {data: 'po_number', name: 'po_number'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'due_date', name: 'due_date'},
                    {data: 'grand_total', name: 'grand_total'},
                    {data: 'paid_amount', name: 'paid_amount'},
                    {data: 'due_amount', name: 'due_amount'},
                    {data: 'paid_at', name: 'paid_at'},
                    {data: 'payment_remarks', name: 'payment_remarks'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
        $(document).on('click', '.doPayment', function (e) {
            console.log($(this).data('id'));
            $('#payAmount').modal('show');
            $('#invoice_id').val($(this).data('id'));
        })
    </script>
@endsection
