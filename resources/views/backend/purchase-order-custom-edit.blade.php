@extends('backend.layout.app')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Edit Purchase Order</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Product Detail</h2>
                            <a href="{{ route('purchase-orders') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-list"></i> Lists</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>{{ Session::get('type') }}</strong> {{ Session::get('message') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    @foreach ($errors->all() as $error)
                                        <strong>Error </strong> {{$error}}<br/>
                                    @endforeach
                                </div>
                            @endif
                            <div class="row">
                                <form class="form-horizontal form-label-left" action="{{ route('purchase-update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2 class="text-success">Additional Information</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <label>Purchase Order No <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-circle"></i></span>
                                                            <input type="text" class="form-control" name="po_number" readonly value="{{$purchase_order->po_number}}">
                                                            <input type="hidden" class="form-control" value="{{$purchase_order->id}}" name="id">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Purchase Order Date <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="date" class="form-control" name="sales_date" readonly placeholder="DD-MM-YYYY" value="{{$purchase_order->order_date}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="input-group col-lg-12">
                                                            <label>Customer Name <span class="text-danger">*</span></label>
                                                            <select name="customer_id" class="form-control selectCustomer" readonly required>
                                                                <option value="">Select Customer Name</option>
                                                                @foreach($customers as $customer)
                                                                    <option value="{{ $customer->id }}" {{($customer->id == $purchase_order->customer_id)?'selected':''}}>{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="input-group col-lg-12">
                                                            <label>Customer Account <span class="text-danger">*</span></label>
                                                            <select name="account_id" class="form-control selectAccountNumber" readonly required>
                                                                <option value="">Select Customer Account</option>
                                                                @if(!empty($purchase_order->customer_account_no))
                                                                    <option value="{{$purchase_order->customer_account_no}}" selected>{{$purchase_order->customer_account_no}}</option>
                                                                @endif
                                                                {{--  @foreach($customers->account as $account)
                                                                      <option value="{{ $account->id }}">{{ $account->account_no }}</option>
                                                                  @endforeach--}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                <!--<div class="col-lg-3">
                                                        <label>Service Start Date <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="date" class="form-control" name="service_start" placeholder="DD-MM-YYYY" value="<?= date('Y-m-d') ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label>Service End Date <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="date" class="form-control" name="service_end" placeholder="DD-MM-YYYY" value="<?= date('Y-m-d') ?>">
                                                        </div>
                                                    </div>-->
                                                </div>
                                                <div class="row">
                                                    <h4>Order Attachment</h4>
                                                    <div class="col-lg-6">
                                                        <div class="input-group col-lg-12">
                                                            <label>Upload {{--<span class="text-danger">*</span>--}}</label>
                                                            <input type="file" name="attachment[]" class="form-control" multiple>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2 class="text-success">Customer Plan Information</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <table id="myTable" class=" table">
                                                        <thead>
                                                        <tr style="font-size: 20px;">
                                                            <td>Services</td>
                                                            <td>SAC Code</td>
                                                            <td>Frequency</td>
                                                            <td>Price</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td class="col-sm-3"><input type="text" name="plan" class="form-control" value="{{ $purchase_order->customerAccount->services->plan }}"/></td>
                                                            <td class="col-sm-3"><input type="text" name="plan_sac_code" class="form-control" value="{{ $purchase_order->customerAccount->services->sac_code }}"/></td>
                                                            <td class="col-sm-3"><input type="number" min="0" name="plan_frequency" class="form-control"
                                                                                        value="{{ $purchase_order->customerAccount->services->frequency }}"/></td>
                                                            <td class="col-sm-3"><input type="number" min="0" name="plan_price" class="form-control subTotal"
                                                                                        value="{{ $purchase_order->customerAccount->services->amount }}"/></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2 class="text-success">Purchase Order Information</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <table id="myTable" class=" table order-list">
                                                        <thead>
                                                        <tr style="font-size: 15px;">
                                                            <td>Product</td>
                                                            <td>SAC Code</td>
                                                            <td>Quantity</td>
                                                            <td>Discount</td>
                                                            <td>Price</td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($purchase_order->items as $i => $item)
                                                            @continue($i == 0)
                                                            <tr>
                                                                <td class="col-sm-3"><input type="text" name="product_name[]" class="form-control" value="{{ $item->product_name }}"/></td>
                                                                <td class="col-sm-2"><input type="text" name="sac_code[]" class="form-control" value="{{ $item->sac_code }}"/></td>
                                                                <td class="col-sm-2"><input type="number" min="0" name="quantity[]" class="form-control" value="{{ $item->quantity }}"/></td>
                                                                <td class="col-sm-2"><input type="number" min="0" name="discount[]" class="form-control" value="{{ $item->discount }}"/></td>
                                                                <td class="col-sm-2"><input type="number" min="0" name="price[]" class="form-control subTotal" value="{{ $item->price }}"/></td>
                                                                <td class="col-sm-1"><a href="javascript:void(0);" class="btn btn-primary" id="addrow"><i class="fa fa-plus-circle"></i></a></td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="input-group col-lg-12">
                                                            <label>Agent <span class="text-danger">*</span></label>
                                                            <select name="user_id" id="" class="form-control">
                                                                @foreach($users as $user)
                                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6" style="float: right">
                                                        <div class="input-group col-lg-12">
                                                            <label>Sub Total<span class="text-danger">*</span></label>
                                                            <input type="text" name="sub_total" class="form-control final_amount" placeholder="Total Amount" value="0.00" readonly="readonly">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-sm btn-success pull-right">UPDATE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('purchase-order-script')
    <script type="application/javascript">
        $(document).on('keyup, change', '.subTotal', function (e) {
            calculateSum();
        });
        $(document).on('change', '.selectCustomer', function (e) {
            if ($(this).val() === '') return false;
            NProgress.start();
            $.ajax({
                type: 'GET',
                url: base_url + '/customers/details/' + $(this).val(),
                data: {},
                dataType: "json",
                success: function (resultData) {
                    if (resultData.data.length === 0) {
                        $('.selectAccountNumber').html('<option value="">Select Customer Account</option>');
                        NProgress.done();
                        return false;
                    }
                    let html = '';
                    $.each(resultData.data, function (i) {
                        html += '<option value="' + resultData.data[i].account_no + '">' + resultData.data[i].account_no + '</option>';
                    });
                    $('.selectAccountNumber').html(html);
                    NProgress.done();
                }
            });
        });
        $(document).ready(function () {
            var counter = 0;
            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";
                cols += '<td><input type="text" class="form-control" name="product_name[]"/></td>';
                cols += '<td><input type="text" class="form-control" name="sac_code[]"/></td>';
                cols += '<td><input type="number" min="0" class="form-control" name="quantity[]"/></td>';
                cols += '<td><input type="number" min="0" class="form-control" name="discount[]"/></td>';
                cols += '<td><input type="number" min="0" class="form-control subTotal" name="price[]"/></td>';
                cols += '<td><a href="javascript:void(0)" class="ibtnDel btn btn-danger"><i class="fa fa-close"></i></a></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                counter++;
                calculateSum();
            });
            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counter -= 1;
                calculateSum();
            });
        });
        function calculateSum() {
            var sum = 0;
            //iterate through each textboxes and add the values
            $(".subTotal").each(function () {
                //add only if the value is number
                if (!isNaN(this.value) && this.value.length != 0) {
                    sum += parseFloat(this.value);
                }
            });
            //.toFixed() method will roundoff the final sum to 2 decimal places
            $(".final_amount").val(sum.toFixed(2));
        }
    </script>
@endsection

