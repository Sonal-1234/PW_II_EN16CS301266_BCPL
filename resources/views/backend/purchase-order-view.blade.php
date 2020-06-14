@extends('backend.layout.app')

@section('customer-styles')
    <link href="{{asset('css/customer-profile.css')}}"/>
@endsection

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
                            <h2>Purchase Order Details</h2>
                            <a href="{{ route('purchase-orders') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-list"></i> Lists</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                                <h3>Additional Information</h3>
                                <ul class="list-unstyled user_data">
                                    <li><strong>Purchase Order No: </strong>{{$purchase_order->po_number}}</li>
                                    <li><strong>Purchase Order Date: </strong>{{$purchase_order->order_date}}</li>
                                    <li><strong>Customer Name: </strong>{{$purchase_order->customerAccount->customer->first_name}}</li>
                                    <li><strong>Customer Account: </strong>{{$purchase_order->customer_account_no}}</li>
                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Order Item</a></li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="profile-tab2">
                                            <table class="data table table-striped no-margin">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="20%">Product Name</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Discount</th>
                                                    <th>Taxable</th>
                                                    <th>Subtotal (Rs)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($purchase_order->items as $i => $item)
                                                    <tr>
                                                        <td>{{  $i+1 }}</td>
                                                        <td>{{$item->product_name}}</td>
                                                        <td>{{$item->price}}</td>
                                                        <td>{{$item->quantity}}</td>
                                                        <td>{{$item->discount}}</td>
                                                        <td>{{$item->taxable}}</td>
                                                        <td>{{$item->total}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h4>Order Attachment</h4>
                                <div class="clearfix"></div>
                                @foreach($purchase_order->attachments as $j => $attachment)
                                    <ul class="list-inline" style="display: inline-block;">
                                        <li>
                                            <a href="{{ asset(\Illuminate\Support\Facades\Storage::url('public/upload/'.$attachment->name)) }}"
                                               target="_blank" class="document"><img src="{{asset('images/attachment.png')}}" class="avatar" alt="Avatar"></a>
                                        </li>
                                    </ul>
                                @endforeach
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h4>Customer Product Information</h4>
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Product: {{$purchase_order->customerAccount->services->plan}}</strong>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <strong>Frequency: {{$purchase_order->customerAccount->services->frequency}} Months</strong>
                                    </div> -->
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h4>Agent Name & Total Amount</h4>
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Agent: {{$purchase_order->user->name}}</strong>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Total Amount: {{$purchase_order->total}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('datatable-script')
@endsection
