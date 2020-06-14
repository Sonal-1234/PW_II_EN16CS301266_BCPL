@extends('backend.layout.app')

@section('datatable-style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .price {
            font-size: 14px !important;
            color: #555 !important;
        }
    </style>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Product Lists</h3>
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
                            <h2>Product Lists</h2>
                            <a href="{{ route('products-add') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-plus-circle"></i> Add</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="datatable table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>SAC Code</th>
                                    <th width="20%">Description</th>
                                    <th>Price</th>
                                    <th>CGST</th>
                                    <th>SGST</th>
                                    <th>IGST</th>
                                    <th width="10%">Type</th>
                                    <th>Quantity</th>
                                    <th width="10%">Action</th>
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
    <div class="modal fade" id="editProductModal"
         tabindex="-1" role="dialog"
         aria-labelledby="productsModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="productsModalLabel">Product Edit</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('products-update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Product Name <b class="red">*</b></label>
                                    <input type="text" class="form-control name" placeholder="Product Name" name="name" value="{{ old('name') }}">
                                    <input type="hidden" name="id" class="id">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>SAC Code <b class="red">*</b></label>
                                    <input type="text" class="form-control sac_code" placeholder="SAC Code" name="sac_code" value="{{ old('sac_code') }}">
                                    @error('sac_code')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description <b class="red">*</b></label>
                                    <textarea type="text" class="form-control description" placeholder="Description" name="description">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Product Type <b class="red">*</b></label>
                                    <select name="type" class="form-control type">
                                        <option value="">Please Select</option>
                                        <option value="SELF_PURCHASE">One Time Cost Product</option>
                                        <option value="GOVERNMENT_CCI">Service Base Product</option>
                                    </select>
                                    @error('type')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Quantity <b class="red">*</b></label>
                                    <input type="text" name="quality" {{ old('quality') }} class="form-control quality">
                                    @error('quality')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Price <b class="red">*</b></label>
                                    <input type="text" class="form-control price" placeholder="price" name="price" value="{{ old('price') }}">
                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>CGST <b class="red">*</b></label>
                                    <input type="text" class="form-control cgst" placeholder="cgst" name="cgst" value="{{ old('cgst') }}">
                                    @error('cgst')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>SGST <b class="red">*</b></label>
                                    <input type="text" class="form-control sgst" placeholder="sgst" name="sgst" value="{{ old('sgst') }}">
                                    @error('sgst')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>IGST <b class="red">*</b></label>
                                    <input type="text" class="form-control igst" placeholder="igst" name="igst" value="{{ old('igst') }}">
                                    @error('igst')
                                    <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
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
                ajax: '{{ route('products-lists') }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'sac_code', name: 'sac_code'},
                    {data: 'description', name: 'description'},
                    {data: 'price', name: 'price'},
                    {data: 'cgst', name: 'cgst'},
                    {data: 'sgst', name: 'sgst'},
                    {data: 'igst', name: 'igst'},
                    {data: 'type', name: 'type'},
                    {data: 'quality', name: 'quality'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
            $(document).on('click', '.productDelete', function (e) {
                if (confirm("Are you sure want to delete this product?")) {
                    NProgress.start();
                    $.ajax({
                        type: 'GET',
                        url: base_url + '/products/delete/' + $(this).data('id'),
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
            $(document).on('click', '.productEdit', function (e) {
                NProgress.start();
                $.ajax({
                    type: 'GET',
                    url: base_url + '/products/edit/' + $(this).data('id'),
                    data: {},
                    dataType: "json",
                    success: function (resultData) {
                        $('#editProductModal').modal('show');
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
