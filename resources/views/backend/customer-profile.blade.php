@extends('backend.layout.app')

@section('customer-styles')
    <link href="{{asset('css/customer-profile.css')}}"/>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Customer</h3>
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
                            <h2>Customer Detail</h2>
                            <a href="{{ route('customers') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-list"></i> Lists</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                                {{--<div class="profile_img">
                                    <div id="crop-avatar">
                                        <!-- Current avatar -->
                                        <img class="img-responsive avatar-view" src="{{asset('images/user.png')}}" alt="Avatar" title="Change the avatar">
                                    </div>
                                </div>--}}
                                <h3>{{ $customer->first_name }} {{ $customer->last_name }}
                                    <a href="javascript:void(0)" data-toggle="modal" class="float-right getCustomerDetails" data-target="#editCustomer" data-id="{{$customer->id}}"><i class="fa fa-pencil"></i></a>
                                </h3>
                                @foreach($customer->user->addresses   as $address)
                                    @continue($address->type == 'RESIDENCE')
                                    <h4>{{ $address->type == 'BILLING' ? 'Billing Address' : 'Service Address' }}
                                        <a href="javascript:void(0)" data-toggle="modal" class="float-right getCustomerAddressDetails" data-target="#editCustomerAddress" data-id="{{$address->id}}"
                                           data-type="{{$address->type}}"><i
                                                    class="fa fa-pencil"></i></a>
                                    </h4>
                                    <ul class="list-unstyled user_data">
                                        <li><i class="fa fa-map-marker user-profile-icon"></i> {{ $address->address1 }}, {{ $address->address2 }}</li>
                                        <li>{{ $address->address3 }}  {{ $address->city }}</li>
                                        <li>{{ $address->state }}</li>
                                        <li><i class="fa fa-mobile"></i> {{ $address->phone1 }}, {{ $address->phone2 }}</li>
                                    </ul>
                                    <hr/>
                                @endforeach
                                <h3>{{ $customer->company->name }}
                                    <a href="javascript:void(0)" data-toggle="modal" class="float-right getCustomerCompanyDetails" data-target="#editCustomerCompany" data-id="{{$customer->company->id}}"><i
                                                class="fa fa-pencil"></i></a>
                                </h3>
                                <h4>{{ $customer->company->contact_person }}</h4>
                                <ul class="list-unstyled user_data">
                                    <li>{{ $customer->company->gst_number }}</li>
                                    <li>{{ $address->address3 }}  {{ $address->city }}</li>
                                    <li><i class="fa fa-mobile"></i> {{ $customer->company->contact_number }}</li>
                                    <li> {{ $customer->company->created_at }}</li>
                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        {{--<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a></li>--}}
                                        <li role="presentation" class="active"><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Accounts</a></li>
                                        {{-- <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Company Detail</a></li>--}}
                                        <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Purchase Orders</a></li>
                                        <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab4" data-toggle="tab" aria-expanded="false">Customer Services</a></li>
                                        <li role="presentation" class=""><a href="#tab_content6" role="tab" id="profile-tab5" data-toggle="tab" aria-expanded="false">Customer Billing</a></li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        {{--<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                            <!-- start recent activity -->
                                            <ul class="messages">
                                                <li>
                                                    <img src="{{asset('images/img.jpg')}}" class="avatar" alt="Avatar">
                                                    <div class="message_date">
                                                        <h3 class="date text-info">24</h3>
                                                        <p class="month">May</p>
                                                    </div>
                                                    <div class="message_wrapper">
                                                        <h4 class="heading">Desmond Davison</h4>
                                                        <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher
                                                            synth.
                                                        </blockquote>
                                                        <br/>
                                                        <p class="url">
                                                            <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                                            <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                                        </p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <img src="{{asset('images/img.jpg')}}" class="avatar" alt="Avatar">
                                                    <div class="message_date">
                                                        <h3 class="date text-error">21</h3>
                                                        <p class="month">May</p>
                                                    </div>
                                                    <div class="message_wrapper">
                                                        <h4 class="heading">Brian Michaels</h4>
                                                        <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher
                                                            synth.
                                                        </blockquote>
                                                        <br/>
                                                        <p class="url">
                                                            <span class="fs1" aria-hidden="true" data-icon=""></span>
                                                            <a href="#" data-original-title="">Download</a>
                                                        </p>
                                                    </div>
                                                </li>
                     Add Billing                           <li>
                                                    <img src="{{asset('images/img.jpg')}}" class="avatar" alt="Avatar">
                                                    <div class="message_date">
                                                        <h3 class="date text-info">24</h3>
                                                        <p class="month">May</p>
                                                    </div>
                                                    <div class="message_wrapper">
                                                        <h4 class="heading">Desmond Davison</h4>
                                                        <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher
                                                            synth.
                                                        </blockquote>
                                                        <br/>
                                                        <p class="url">
                                                            <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                                            <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                                        </p>
                                                    </div>
                                                </li>
                                                <li>
                                                    <img src="{{asset('images/img.jpg')}}" class="avatar" alt="Avatar">
                                                    <div class="message_date">
                                                        <h3 class="date text-error">21</h3>
                                                        <p class="month">May</p>
                                                    </div>
                                                    <div class="message_wrapper">
                                                        <h4 class="heading">Brian Michaels</h4>
                                                        <blockquote class="message">Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher
                                                            synth.
                                                        </blockquote>
                                                        <br/>
                                                        <p class="url">
                                                            <span class="fs1" aria-hidden="true" data-icon=""></span>
                                                            <a href="#" data-original-title="">Download</a>
                                                        </p>
                                                    </div>
                                                </li>
                                            </ul>
                                            <!-- end recent activity -->
                                        </div>--}}
                                        {{--<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                            <!-- start user projects -->
                                            <table class="data table table-striped no-margin">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Company Name</th>
                                                    <th>Contact Person</th>
                                                    <th>Contact Number</th>
                                                    <th>GST Number</th>
                                                    <th>Created At</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ $customer->company->name }}</td>
                                                    <td>{{ $customer->company->contact_number }}</td>
                                                    <td>{{ $customer->company->contact_person }}</td>
                                                    <td>{{ $customer->company->gst_number }}</td>
                                                    <td>{{ $customer->company->created_at }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!-- end user projects -->
                                        </div>--}}
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="profile-tab2">
                                            <a href="javascript:void(0);" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addAccount"><i class="fa fa-plus-circle"></i> Add New Account</a>
                                            <table class="data table table-striped no-margin">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Attachment</th>
                                                    <th>Account Number</th>
                                                    <th>Status</th>
                                                    <th>Due Invoice Reminder</th>
                                                    <th>Invoice Reminder</th>
                                                    <th width="20%">Account Description</th>
                                                    <th>Created At</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($customer->accounts as $i => $account)

                                                    <tr>
                                                        <td>{{ $i+1 }}</td>
                                                        <td>
                                                            <div class="row">
                                                                @foreach($customer->account_attachments->where('customer_account_no', '=', $account->account_no) as $j => $accountAttachment)
                                                                    <ul class="list-inline" style="display: inline-block;">
                                                                        <li>
                                                                            <a href="{{ asset(\Illuminate\Support\Facades\Storage::url('public/upload/'.$accountAttachment->name)) }}"
                                                                               target="_blank" class="document"><img src="{{asset('images/attachment.png')}}" class="avatar" alt="Avatar"></a>
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        <td>{{ $account->account_no }}</td>
                                                        <td>
                                                            @if($account->status === 'ACTIVE')
                                                                <a href="javascript:void(0);" class="btn btn-xs btn-success changeAccountStatus" data-id="{{$account->account_no}}" data-value="DE-ACTIVE">ACTIVE</a>
                                                            @else
                                                                <a href="javascript:void(0);" class="btn btn-xs btn-danger changeAccountStatus" data-id="{{$account->account_no}}" data-value="ACTIVE">DE-ACTIVE</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($account->due_invoice_reminder === 1)
                                                                <a href="javascript:void(0);" class="btn btn-xs btn-success changeDueInvoiceReminder" data-id="{{$account->account_no}}" data-value="0">YES</a>
                                                            @else
                                                                <a href="javascript:void(0);" class="btn btn-xs btn-danger changeDueInvoiceReminder" data-id="{{$account->account_no}}" data-value="1">NO</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($account->invoice_reminder === 1)
                                                                <a href="javascript:void(0);" class="btn btn-xs btn-success changeInvoiceReminder" data-id="{{$account->account_no}}" data-value="0">YES</a>
                                                            @else
                                                                <a href="javascript:void(0);" class="btn btn-xs btn-danger changeInvoiceReminder" data-id="{{$account->account_no}}" data-value="1">NO</a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $account->description }}</td>
                                                        <td>{{ $account->created_at }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab3">
                                            <a href="{{ route('purchase-create') }}" class="btn btn-xs btn-primary"><i class="fa fa-plus-circle"></i> Add New Purchase Order</a>
                                            <table class="datatable table table-striped table-bordered" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>PO Number</th>
                                                    <th>Order Date</th>
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
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab4">
                                            <table class="customerServicesDataTables table table-striped table-bordered" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Customer Account Number</th>
                                                    <th>Service Status</th>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <!-- <th>Start Date</th>
                                                    <th>Expire Date</th> -->
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab_content6" aria-labelledby="profile-tab5">
                                            <a href="javascript:void(0);" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addBilling"><i class="fa fa-plus-circle"></i> Add New Billing</a>
                                            <table class="customerBillingDataTables table table-striped table-bordered" style="width: 100%">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Customer Account Number</th>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Discount</th>
                                                    <th>Total</th>
                                                    <th>Taxable</th>
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
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="editCustomerAddress" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Customer Address</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('customers-address-update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Address1 <b class="red">*</b></label>
                                    <textarea name="address1" class="form-control address1"></textarea>
                                    <input type="hidden" name="id" class="id" value="{{ $address->id }}">
                                </div>
                                <div class="form-group">
                                    <label>Address2 </label>
                                    <textarea name="address2" class="form-control address2"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Address3 </label>
                                    <textarea name="address3" class="form-control address3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>City <b class="red">*</b></label>
                                    <input type="text" class="form-control city" placeholder="city" name="city">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>State <b class="red">*</b></label>
                                    <input type="text" class="form-control state" placeholder="state" name="state">
                                </div>
                                <div class="form-group">
                                    <label>Postal Code <b class="red">*</b></label>
                                    <input type="text" class="form-control postal_code" placeholder="Postal Code" name="postal_code">
                                </div>
                                <div class="form-group">
                                    <label>Phone1 <b class="red">*</b></label>
                                    <input type="text" class="form-control phone1" placeholder="phone1" name="phone1">
                                </div>
                                <div class="form-group">
                                    <label>Phone2</label>
                                    <input type="text" class="form-control phone2" placeholder="phone2" name="phone2">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="editCustomerCompany" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Customer Company</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('customers-company-update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Company Name <b class="red">*</b></label>
                                    <input type="text" class="form-control name" placeholder="First Name" name="name">
                                    <input type="hidden" name="id" class="id" value="{{ $customer->company->id }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Contact Number <b class="red">*</b></label>
                                    <input type="text" class="form-control contact_number" placeholder="Contact Number" name="contact_number">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Contact Person <b class="red">*</b></label>
                                    <input type="text" class="form-control contact_person" placeholder="Contact Person" name="contact_person">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>GST Number <b class="red">*</b></label>
                                    <input type="text" class="form-control gst_number" placeholder="GST NUMBER" name="gst_number">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="editCustomer" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Customer Detail</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('customers-update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>First Name <b class="red">*</b></label>
                                    <input type="text" class="form-control first_name" placeholder="First Name" name="first_name">
                                    <input type="hidden" name="id" class="id" value="{{$customer->id}}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Last Name <b class="red">*</b></label>
                                    <input type="text" class="form-control last_name" placeholder="Last Name" name="last_name">
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Email <b class="red">*</b></label>
                                    <input type="email" class="form-control email" placeholder="abc@example.com" name="email">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Phone <b class="red">*</b></label>
                                    <input type="text" class="form-control phone1" placeholder="+91-0123456789" name="phone1">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Phone2 </label>
                                    <input type="text" class="form-control phone2" placeholder="+91-0123456789" name="phone2">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="editCustomerService" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Customer Service</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('customers-service-update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Plan <b class="red">*</b></label>
                                    <select name="plan" id="" class="form-control">
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="id" class="id">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Frequency <b class="red">*</b></label>
                                    <select name="frequency" class="form-control selectFrequency" required>
                                        <option value="">Please Select Plan Frequency</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ $i }} Month</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="addAccount" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Customer Account</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('customers-account-add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Account Number <b class="red">*</b></label>
                                    <input type="text" class="form-control name" placeholder="Account Number" name="account_no" value="{{ time() }}" readonly>
                                    <input type="hidden" name="customer_id" value="{{$customer->id}}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Due Invoice Reminder <b class="red">*</b></label>
                                    <select name="due_invoice_reminder" class="form-control" id="due_invoice_reminder">
                                        <option value="">Select</option>
                                        <option value="{{1}}" selected>YES</option>
                                        <option value="{{0}}">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Invoice Reminder <b class="red">*</b></label>
                                    <select name="invoice_reminder" class="form-control" id="invoice_reminder">
                                        <option value="">Select</option>
                                        <option value="{{1}}" selected>YES</option>
                                        <option value="{{0}}">NO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Attachments</label>
                                    <input type="file" name="attachment[]" id="attachment" multiple>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <label>Account Description <b class="red">*</b></label>
                                <div class="form-group">
                                    <textarea class="form-control" name="description" id="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success">Add</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="addBilling" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Billing</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left" action="{{ route('add-billing') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Account Number <b class="red">*</b></label>
                                    <select name="account_no" class="form-control">
                                        <option value="">Please Select Customer Account</option>
                                        @foreach($customer->accounts as $accounts)
                                            <option value="{{ $accounts->account_no }}">{{ $accounts->account_no }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="customer_id" value="{{$customer->id}}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Product Name <b class="red">*</b></label>
                                    <select name="product_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Quantity <b class="red">*</b></label>
                                    <input type="number" min="0" name="quantity" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="number" min="0" name="discount" value="00.00" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-sm btn-success">Add</button>
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
                ajax: '{{ route('customers-purchase-orders-lists',['customerId' => $customer->id]) }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'po_number', name: 'po_number'},
                    {data: 'order_date', name: 'order_date'},
                    {data: 'customer_account_no', name: 'customer_account_no'},
                    {data: 'total', name: 'total'},
                    {data: 'discount', name: 'discount'},
                    {data: 'taxable', name: 'taxable'},
                    {data: 'grand_total', name: 'grand_total'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "bLengthChange": false, //thought this line could hide the LengthMenu
                "bInfo": false,
            });
        });
        $(document).ready(function () {
            $('.customerServicesDataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('customers-services-lists',['customerId' => $customer->id]) }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'customer_account_no', name: 'customer_account_no'},
                    {data: 'status', name: 'status'},
                    {data: 'plan', name: 'plan'},
                    {data: 'frequency', name: 'frequency'},
                    // {data: 'start_date', name: 'start_date'},
                    // {data: 'expire_date', name: 'expire_date'},
                    {data: 'action', name: 'action'}
                ],
                "bLengthChange": false, //thought this line could hide the LengthMenu
                "bInfo": false,
            });
        });
        $(document).ready(function () {
            $('.customerBillingDataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('customers-billing-lists',['customerId' => $customer->id]) }}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'customer_account_no', name: 'customer_account_no'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'price', name: 'price'},
                    {data: 'discount', name: 'discount'},
                    {data: 'total', name: 'total'},
                    {data: 'taxable', name: 'taxable'},
                    {data: 'grand_total', name: 'grand_total'},
                    {data: 'action', name: 'action'}
                ],
                "bLengthChange": false, //thought this line could hide the LengthMenu
                "bInfo": false,
            });
        });
        $(document).on('click', '.changeAccountStatus', function (e) {
            if (confirm("Are you sure want to " + $(this).data('value') + " this customer account?")) {
                NProgress.start();
                $.ajax({
                    type: 'GET',
                    url: base_url + '/customers/change/account/status/' + $(this).data('id') + '/' + $(this).data('value'),
                    data: {},
                    dataType: "json",
                    success: function (resultData) {
                        location.reload();
                        NProgress.done();
                    }
                });
            }
        });
        $(document).on('click', '.changeDueInvoiceReminder', function (e) {
            if (confirm("Are you sure want to due reminder for invoice?")) {
                NProgress.start();
                $.ajax({
                    type: 'GET',
                    url: base_url + '/customers/change/due/reminder/status/' + $(this).data('id') + '/' + $(this).data('value'),
                    data: {},
                    dataType: "json",
                    success: function (resultData) {
                        location.reload();
                        NProgress.done();
                    }
                });
            }
        });
        $(document).on('click', '.changeInvoiceReminder', function (e) {
            if (confirm("Are you sure want to reminder for invoice?")) {
                NProgress.start();
                $.ajax({
                    type: 'GET',
                    url: base_url + '/customers/change/reminder/status/' + $(this).data('id') + '/' + $(this).data('value'),
                    data: {},
                    dataType: "json",
                    success: function (resultData) {
                        location.reload();
                        NProgress.done();
                    }
                });
            }
        });
        $(document).on('click', '.getCustomerDetails', function (e) {
            NProgress.start();
            $.ajax({
                type: 'GET',
                url: base_url + '/customers/edit/' + $(this).data('id'),
                data: {},
                dataType: "json",
                success: function (resultData) {
                    console.log(resultData);
                    $.each(resultData.data, function (index, value) {
                        $("." + index).val(value);
                    });
                    //  location.reload();
                    NProgress.done();
                }
            });
        });
        $(document).on('click', '.getCustomerCompanyDetails', function (e) {
            NProgress.start();
            $.ajax({
                type: 'GET',
                url: base_url + '/customers/company/edit/' + $(this).data('id'),
                data: {},
                dataType: "json",
                success: function (resultData) {
                    console.log(resultData);
                    $.each(resultData.data, function (index, value) {
                        $("." + index).val(value);
                    });
                    //  location.reload();
                    NProgress.done();
                }
            });
        });
        $(document).on('click', '.getCustomerAddressDetails', function (e) {
            NProgress.start();
            $.ajax({
                type: 'GET',
                url: base_url + '/customers/address/edit/' + $(this).data('id'),
                data: {},
                dataType: "json",
                success: function (resultData) {
                    console.log(resultData);
                    $.each(resultData.data, function (index, value) {
                        $("." + index).val(value);
                    });
                    //  location.reload();
                    NProgress.done();
                }
            });
        });
        $(document).on('click', '.getCustomerServiceDetails', function (e) {
            NProgress.start();
            $.ajax({
                type: 'GET',
                url: base_url + '/customers/services/edit/' + $(this).data('id'),
                data: {},
                dataType: "json",
                success: function (resultData) {
                    console.log(resultData);
                    $.each(resultData.data, function (index, value) {
                        $("." + index).val(value);
                    });
                    //  location.reload();
                    NProgress.done();
                }
            });
        });
    </script>
@endsection
