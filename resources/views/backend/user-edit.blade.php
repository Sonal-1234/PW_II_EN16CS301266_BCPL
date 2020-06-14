@extends('backend.layout.app')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>User Edit</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>User Detail</h2>
                            <a href="{{ route('users') }}" class="btn btn-xs btn-primary" style="float: right"><i class="fa fa-list"></i> Lists</a>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(Session::has('message'))
                                <div class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>{{ Session::get('type') }}</strong> {{ Session::get('message') }}
                                </div>
                            @endif
                            <form class="form-horizontal form-label-left" action="{{ route('user-update', $user->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <h2>Personal Detail</h2>
                                    <div class="col-lg-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Name <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Phone1 <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="Phone1" name="phone1" value="{{ $user->phone1 }}">
                                            @error('phone1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Phone2</label>
                                            <input type="text" class="form-control" placeholder="Phone2" name="phone2" value="{{ $user->phone2 }}">
                                            @error('phone2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label>Email <b class="red">*</b></label>
                                            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Password <b class="red">*</b></label>
                                            <input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}">
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="red">{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Role <b class="red">*</b></label>
                                            <select name="role" id="" class="form-control">
                                                <option value="">Please Select Role</option>
                                                <option value="AGENT" {{ $user->authority->authority_name == 'AGENT' ? 'selected' : null }}>AGENT</option>
                                                <option value="ADMIN" {{ $user->authority->authority_name == 'ADMIN' ? 'selected' : null }}>ADMIN</option>
                                            </select>
                                            @error('role')
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
