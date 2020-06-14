@extends('backend.layout.app')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Purchase Order</h3>
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
                                <form class="form-horizontal form-label-left" action="{{ route('purchase-store') }}" method="POST" enctype="multipart/form-data">
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
                                                            <input type="text" class="form-control" name="po_number" value="PO-<?= time() ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label>Purchase Order Date <span class="text-danger">*</span></label>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                            <input type="date" class="form-control" name="sales_date" placeholder="DD-MM-YYYY" value="<?= date('Y-m-d') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="input-group col-lg-12">
                                                            <label>Customer Name <span class="text-danger">*</span></label>
                                                            <select name="customer_id" class="form-control selectCustomer" required>
                                                                <option value="">Select Customer Name</option>
                                                                @foreach($customers as $customer)
                                                                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="input-group col-lg-12">
                                                            <label>Customer Account <span class="text-danger">*</span></label>
                                                            <select name="account_id" class="form-control selectAccountNumber" required>
                                                                <option value="">Select Customer Account</option>
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
                                                <h2 class="text-success">Customer Product Information</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-12 col-xs-12">
                                                        <div class="form-group" style="margin-bottom: 0;">
                                                            <div class="input-group wide-tip">
                                                                <div class="input-group-addon">
                                                                Products
                                                                </div>
                                                                <select name="plan" class="form-control col-lg-8 selectPlan" required>
                                                                    <option value="">Select Product</option>
                                                                    @foreach($plans as $plan)
                                                                        <option value="{{ $plan->id }}">{{ $plan->name }}-{{ $plan->sac_code }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-xs-12">
                                                        <div class="form-group" style="margin-bottom: 0;">
                                                            <div class="input-group wide-tip">
                                                                <div class="input-group-addon">
                                                                    Quantity
                                                                </div>
                                                                <select name="frequency" class="form-control selectFrequency" required>
                                                                    <option value="">Please Select Product Quantity</option>
                                                                    @for ($i = 1; $i <= 12; $i++)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12 col-xs-12">
                                                        <a href="javascript:;" class="btn btn-primary addService" id="addItem">Add</a>
                                                    </div>
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
                                                    <div class="col-lg-4 col-md-12 col-xs-12">
                                                        <div class="form-group" style="margin-bottom: 0;">
                                                            <div class="input-group wide-tip">
                                                                <div class="input-group-addon">
                                                                    Product
                                                                </div>
                                                                <select id="product_id" name="product_id" class="form-control col-lg-8 selectProduct">
                                                                    <option value="">Select Product To Purchase</option>
                                                                    @foreach($products as $product)
                                                                        <option value="{{ $product->id }}">{{ $product->name }}-{{ $product->sac_code }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12 col-xs-12 showHideValue">
                                                        <div class="form-group" style="margin-bottom: 0;">
                                                            <div class="input-group wide-tip">
                                                                <div id="qtyLoadImg" class="input-group-addon">
                                                                    QTY
                                                                </div>
                                                                <input type="number" min="0" class="form-control col-lg-8 item_qty" name="quantity">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12 col-xs-12 showHideValue">
                                                        <div class="form-group" style="margin-bottom: 0;">
                                                            <div class="input-group wide-tip">
                                                                <div id="amountLoadImg" class="input-group-addon">
                                                                    Amount
                                                                </div>
                                                                <input class="form-control col-lg-8 amount" name="amount">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12 col-xs-12">
                                                        <a href="javascript:;" class="btn btn-primary addItems" id="addItem">Add</a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <h4>Order Item</h4>
                                                        <table class="table items table-striped table-bordered table-condensed table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th class="col-md-8">Product Name</th>
                                                                <th class="col-md-1">Price</th>
                                                                <th class="col-md-1">Quantity</th>
                                                                <th class="col-md-1">Discount</th>
                                                                <th class="col-md-2">Subtotal&nbsp;(<span class="currency">Rs</span>)</th>
                                                                <th style="width: 10px !important; text-align: center;"><i class="fa fa-trash-o text-danger"></i></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="myTable">
                                                            </tbody>
                                                            <tfoot>
                                                            <tr id="tfoot" class="tfoot active">
                                                                <th colspan="4"><span class="pull-right"><strong class="text-success">Total Amount :</strong></span></th>
                                                                <th class="text-right">
                                                                    <span class="pull-right"><strong class="text-success total_amount">0.00</strong></span>
                                                                </th>
                                                                <th class="text-center">&nbsp;</th>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
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
                                                            <label>Total Amount <span class="text-danger">*</span></label>
                                                            <input type="text" name="total_amount" class="form-control final_amount" placeholder="Total Amount" value="0.00" readonly="readonly">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-sm btn-success pull-right">SAVE</button>
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
    <script src="{{asset('js/purchase-order.js')}}"></script>
@endsection

