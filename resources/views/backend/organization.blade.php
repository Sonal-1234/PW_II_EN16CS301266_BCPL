@extends('backend.layout.app')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Organization</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Organization Detail</h2>
                            <a href="{{ route('organizations') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-list"></i> Lists</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>{{ Session::get('type') }}</strong> {{ Session::get('message') }}
                                </div>
                            @endif
                            <form class="form-horizontal form-label-left" action="{{ route('organizations-store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Organization Name <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Organization Name" name="name" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Organization Email <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Organization Email" name="email" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Owner Name <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('owner_name') is-invalid @enderror" placeholder="Owner Name" name="owner_name" value="{{ old('owner_name') }}">
                                            @error('owner_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Pan No <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('pan_no') is-invalid @enderror" placeholder="Pan No." name="pan_no" value="{{ old('pan_no') }}">
                                            @error('pan_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Registration No <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('registration_no') is-invalid @enderror" placeholder="Registration No." name="registration_no"
                                                   value="{{ old('registration_no') }}">
                                            @error('registration_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
{{--                                            <label>Organization Code <b class="red">*</b></label>--}}
                                            <input type="hidden" class="form-control @error('organization_code') is-invalid @enderror" placeholder="Organization Code" name="organization_code"
                                                   value="{{ (old('organization_code'))?old('organization_code'):'xyz' }}">
                                            @error('organization_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Logo <b class="red">*</b></label>
                                            <input type="file" class="form-control @error('logo') is-invalid @enderror" name="logo">
                                            @error('logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>GSTIN No. <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('gstin_no') is-invalid @enderror" placeholder="GSTIN No." name="gstin_no" value="{{ old('gstin_no') }}">
                                            @error('gstin_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Is Default <b class="red">*</b></label>
                                            <select name="is_default" class="form-control @error('is_default') is-invalid @enderror">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            @error('is_default')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h2>Address Detail</h2>
                                    <div class="col-lg-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Address1 <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('address1') is-invalid @enderror" placeholder="address1" name="address1" value="{{ old('address1') }}">
                                            @error('address1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Address2 <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('address2') is-invalid @enderror" placeholder="address2" name="address2" value="{{ old('address2') }}">
                                            @error('address2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Address3</label>
                                            <input type="text" class="form-control @error('address3') is-invalid @enderror" placeholder="address3" name="address3" value="{{ old('address3') }}">
                                            @error('address3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>City <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('city') is-invalid @enderror" placeholder="city" name="city" value="{{ old('city') }}">
                                            @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>State <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('state') is-invalid @enderror" placeholder="state" name="state" value="{{ old('state') }}">
                                            @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Postal Code <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" placeholder="Postal Code" name="postal_code" value="{{ old('postal_code') }}">
                                            @error('postal_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Phone1 <b class="red">*</b></label>
                                            <input type="text" class="form-control @error('phone1') is-invalid @enderror" placeholder="phone1" name="phone1" value="{{ old('phone1') }}">
                                            @error('phone1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Phone2</label>
                                            <input type="text" class="form-control @error('phone2') is-invalid @enderror" placeholder="phone2" name="phone2" value="{{ old('phone2') }}">
                                            @error('phone2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="clearfix"></div>
                                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
