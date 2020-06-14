@extends('backend.layout.app')

@section('datatable-style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Customers</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Customer Lists</h2>
                            <a href="{{ route('customers-add') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-plus-circle"></i> Add</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="datatable table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Company Name</th>
                                    <th>Phone 1</th>
                                    <th>Phone 2</th>
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
    <div class="modal fade" id="editCustomerModal"
         tabindex="-1" role="dialog"
         aria-labelledby="productsModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="productsModalLabel">Customer Edit</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('customers-update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <h2>Personal Detail</h2>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>First Name <b class="red">*</b></label>
                                    <input type="text" class="form-control first_name" placeholder="First Name" name="first_name" value="{{ old('first_name') }}">
                                    <input type="hidden" class="form-control id" name="id">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Last Name <b class="red">*</b></label>
                                    <input type="text" class="form-control last_name" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Phone1 <b class="red">*</b></label>
                                    <input type="text" class="form-control customer_phone1" placeholder="Phone1" name="customer_phone1" value="{{ old('customer_phone1') }}">
                                    @error('customer_phone1')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Phone2</label>
                                    <input type="text" class="form-control customer_phone2" placeholder="Phone2" name="customer_phone2" value="{{ old('customer_phone2') }}">
                                    @error('customer_phone2')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email <b class="red">*</b></label>
                                    <input type="text" class="form-control email" placeholder="Email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h2>Company Detail</h2>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Company Name <b class="red">*</b></label>
                                    <input type="text" class="form-control company_name" placeholder="Company Name" name="company_name" value="{{ old('company_name') }}">
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Contact Number<b class="red">*</b></label>
                                    <input type="text" class="form-control contact_number" placeholder="Contact Number" name="contact_number" value="{{ old('contact_number') }}">
                                    @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Contact Person<b class="red">*</b></label>
                                    <input type="text" class="form-control contact_person" placeholder="Contact Person" name="contact_person" value="{{ old('contact_person') }}">
                                    @error('contact_person')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>GST Number <b class="red">*</b></label>
                                    <input type="text" class="form-control gst_number" placeholder="GST Number" name="gst_number" value="{{ old('gst_number') }}">
                                    @error('gst_number')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h2>Address Detail <i>(Billing)</i></h2>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Address1 <b class="red">*</b></label>
                                        <textarea name="billing_address1" class="form-control billing_address1">{{ old('billing_address1') }}</textarea>
                                        @error('billing_address1')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Address2 </label>
                                        <textarea name="billing_address2" class="form-control billing_address2">{{ old('billing_address2') }}</textarea>
                                        @error('billing_address2')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Address3 </label>
                                        <textarea name="billing_address3" class="form-control billing_address3">{{ old('billing_address3') }}</textarea>
                                        @error('billing_address3')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>City <b class="red">*</b></label>
                                        <input type="text" class="form-control billing_city" placeholder="city" name="billing_city" value="{{ old('billing_city') }}">
                                        @error('billing_city')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>State <b class="red">*</b></label>
                                        <input type="text" class="form-control billing_state" placeholder="state" name="billing_state" value="{{ old('billing_state') }}">
                                        @error('billing_state')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Postal Code <b class="red">*</b></label>
                                        <input type="text" class="form-control billing_postal_code" placeholder="Postal Code" name="billing_postal_code" value="{{ old('billing_postal_code') }}">
                                        @error('billing_postal_code')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Phone1 <b class="red">*</b></label>
                                        <input type="text" class="form-control billing_phone1" placeholder="phone1" name="billing_phone1" value="{{ old('billing_phone1') }}">
                                        @error('billing_phone1')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Phone2</label>
                                        <input type="text" class="form-control billing_phone2" placeholder="phone2" name="billing_phone2" value="{{ old('billing_phone2') }}">
                                        @error('billing_phone2')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h2>Address Detail <i>(Installation)</i></h2>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>Address1 <b class="red">*</b></label>
                                        <textarea name="installation_address1" class="form-control installation_address1">{{ old('installation_address1') }}</textarea>
                                        @error('installation_address1')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Address2 </label>
                                        <textarea name="installation_address2" class="form-control installation_address2">{{ old('installation_address2') }}</textarea>
                                        @error('installation_address2')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Address3 </label>
                                        <textarea name="installation_address3" class="form-control installation_address3">{{ old('installation_address3') }}</textarea>
                                        @error('installation_address3')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>City <b class="red">*</b></label>
                                        <input type="text" class="form-control installation_city" placeholder="city" name="installation_city" value="{{ old('installation_city') }}">
                                        @error('installation_city')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label>State <b class="red">*</b></label>
                                        <input type="text" class="form-control installation_state" placeholder="state" name="installation_state" value="{{ old('installation_state') }}">
                                        @error('installation_state')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Postal Code <b class="red">*</b></label>
                                        <input type="text" class="form-control installation_postal_code" placeholder="Postal Code" name="installation_postal_code" value="{{ old('installation_postal_code') }}">
                                        @error('installation_postal_code')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Phone1 <b class="red">*</b></label>
                                        <input type="text" class="form-control installation_phone1" placeholder="phone1" name="installation_phone1" value="{{ old('installation_phone1') }}">
                                        @error('installation_phone1')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Phone2 </label>
                                        <input type="text" class="form-control installation_phone2" placeholder="phone2" name="installation_phone2" value="{{ old('installation_phone2') }}">
                                        @error('installation_phone2')
                                        <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success pull-right">Update</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-default"
                            data-dismiss="modal">Close
                    </button>
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
                ajax: '{{ route('customers-lists') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'company_name', name: 'company_name'},
                    {data: 'phone1', name: 'phone1'},
                    {data: 'phone2', name: 'phone2'},
                    {data: 'email', name: 'email'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            $(document).on('click', '.customerDelete', function (e) {
                if (confirm("Are you sure want to delete this customer?")) {
                    NProgress.start();
                    $.ajax({
                        type: 'GET',
                        url: base_url + '/customers/delete/' + $(this).data('id'),
                        data: {},
                        dataType: "json",
                        success: function (resultData) {
                            console.log(resultData);
                            table.ajax.reload();
                            NProgress.done();
                        }
                    });
                }
            });
            $(document).on('click', '.customerEdit', function (e) {
                NProgress.start();
                $.ajax({
                    type: 'GET',
                    url: base_url + '/customers/edit/' + $(this).data('id'),
                    data: {},
                    dataType: "json",
                    success: function (resultData) {
                        $('#editCustomerModal').modal('show');
                        console.log(resultData);
                        $.each(resultData.data, function (index, value) {
                            $("." + index).val(value);
                        });
                        NProgress.done();
                    }
                });
            });
        });
    </script>
@endsection
