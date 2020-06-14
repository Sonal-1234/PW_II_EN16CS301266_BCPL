@extends('backend.layout.app')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Product</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Product Detail</h2>
                            <a href="{{ route('products') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-list"></i> Lists</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>{{ Session::get('type') }}</strong> {{ Session::get('message') }}
                                </div>
                            @endif
                            <form class="form-horizontal form-label-left" action="{{ route('products-store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Product Name <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="Product Name" name="name" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>SAC Code <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="SAC Code" name="sac_code" value="{{ old('sac_code') }}">
                                            @error('sac_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Description <b class="red">*</b></label>
                                            <textarea type="text" class="form-control" placeholder="Description" name="description">{{ old('description') }}</textarea>
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Product Type <b class="red">*</b></label>
                                            <select name="type" class="form-control">
                                                <option value="">Please Select</option>
                                                <option value="SELF_PURCHASE">Self Purchase</option>
                                                <option value="GOVERNMENT_CCI">Government(CCI)</option>
                                            </select>
                                            @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Product Quantity <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="Quantity" name="quality" value="{{ old('quality') }}">
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
                                            <input type="text" class="form-control" placeholder="price" name="price" value="{{ old('price') }}">
                                            @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>CGST <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="cgst" name="cgst" value="{{ old('cgst') }}">
                                            @error('cgst')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>SGST <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="sgst" name="sgst" value="{{ old('sgst') }}">
                                            @error('sgst')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>IGST <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="igst" name="igst" value="{{ old('igst') }}">
                                            @error('igst')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
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
