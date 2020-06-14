@extends('backend.layout.app')

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
                        <div class="x_title">
                            <h2>Customer Detail</h2>
                            <a href="{{ route('customers') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-list"></i> Lists</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>{{ Session::get('type') }}</strong> {{ Session::get('message') }}
                                </div>
                            @endif
                            <form class="form-horizontal form-label-left" action="{{ route('customers-store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <h2>Personal Detail</h2>
                                    <div class="col-lg-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>First Name <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}">
                                            @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Last Name <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Phone1 <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="Phone1" name="customer_phone1" value="{{ old('customer_phone1') }}">
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
                                            <input type="text" class="form-control" placeholder="Phone2" name="customer_phone2" value="{{ old('customer_phone2') }}">
                                            @error('customer_phone2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Email {{--<b class="red">*</b>--}}</label>
                                            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
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
                                            <input type="text" class="form-control" placeholder="Company Name" name="company_name" value="{{ old('company_name') }}">
                                            @error('company_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Contact Number<b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="Contact Number" name="contact_number" value="{{ old('contact_number') }}">
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
                                            <input type="text" class="form-control" placeholder="Contact Person" name="contact_person" value="{{ old('contact_person') }}">
                                            @error('contact_person')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>GST Number {{--<b class="red">*</b>--}}</label>
                                            <input type="text" class="form-control" placeholder="GST Number" name="gst_number" value="{{ old('gst_number') }}">
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
                                                <textarea name="billing_address1" class="form-control">{{ old('billing_address1') }}</textarea>
                                                @error('billing_address1')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Address2 </label>
                                                <textarea name="billing_address2" class="form-control">{{ old('billing_address2') }}</textarea>
                                                @error('billing_address2')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Address3 </label>
                                                <textarea name="billing_address3" class="form-control">{{ old('billing_address3') }}</textarea>
                                                @error('billing_address3')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>City <b class="red">*</b></label>
                                                <input type="text" class="form-control" placeholder="city" name="billing_city" value="{{ old('billing_city') }}">
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
                                                <input type="text" class="form-control" placeholder="state" name="billing_state" value="{{ old('billing_state') }}">
                                                @error('billing_state')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Postal Code <b class="red">*</b></label>
                                                <input type="text" class="form-control" placeholder="Postal Code" name="billing_postal_code" value="{{ old('billing_postal_code') }}">
                                                @error('billing_postal_code')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Phone1 <b class="red">*</b></label>
                                                <input type="text" class="form-control" placeholder="phone1" name="billing_phone1" value="{{ old('billing_phone1') }}">
                                                @error('billing_phone1')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Phone2</label>
                                                <input type="text" class="form-control" placeholder="phone2" name="billing_phone2" value="{{ old('billing_phone2') }}">
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
                                                <textarea name="installation_address1" class="form-control">{{ old('installation_address1') }}</textarea>
                                                @error('installation_address1')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Address2 </label>
                                                <textarea name="installation_address2" class="form-control">{{ old('installation_address2') }}</textarea>
                                                @error('installation_address2')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Address3 </label>
                                                <textarea name="installation_address3" class="form-control">{{ old('installation_address3') }}</textarea>
                                                @error('installation_address3')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>City <b class="red">*</b></label>
                                                <input type="text" class="form-control" placeholder="city" name="installation_city" value="{{ old('installation_city') }}">
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
                                                <input type="text" class="form-control" placeholder="state" name="installation_state" value="{{ old('installation_state') }}">
                                                @error('installation_state')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Postal Code <b class="red">*</b></label>
                                                <input type="text" class="form-control" placeholder="Postal Code" name="installation_postal_code" value="{{ old('installation_postal_code') }}">
                                                @error('installation_postal_code')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Phone1 <b class="red">*</b></label>
                                                <input type="text" class="form-control" placeholder="phone1" name="installation_phone1" value="{{ old('installation_phone1') }}">
                                                @error('installation_phone1')
                                                <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Phone2 </label>
                                                <input type="text" class="form-control" placeholder="phone2" name="installation_phone2" value="{{ old('installation_phone2') }}">
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
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
