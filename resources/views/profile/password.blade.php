@extends('layouts.app')

@section('content')

<div class="content">
	<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">User</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
                <h4 class="page-title">Change Password</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
	<form id="password-form" action="{{ route('profile.passwordUpdate')}}">
        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-form-textbox-password me-1"></i> Change Password</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="old_password" class="form-label">Old Password</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Enter Old Password" value="">
                    <span class="error"></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" value="">
                    <span class="error"></span>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter Confirm Password" value="">
                    <span class="error"></span>
                </div>
            </div>
        </div> <!-- end row -->       
        
        <div class="text-start">
            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
        </div>
    </form>	
</div>
@endsection

@section('js')
	<script>
	    var addUrl = $('#password-form').attr('action');
	    var page_reload = false;
	</script>
@endsection

@section('pagejs')
	<script src="{{asset('/js')}}/page/password.js"></script>
@endsection