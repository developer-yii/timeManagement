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
                        <li class="breadcrumb-item active">My Account</li>
                    </ol>
                </div>
                <h4 class="page-title">My Account</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
	<form id="profile-form" action="{{ route('updateProfile')}}">
        <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $user->name }}">
                    <span class="error"></span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ $user->email }}">
                    <span class="error"></span>
                </div>
            </div>
        </div> <!-- end row -->       
        
        <div class="text-start">
            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
        </div>
    </form>
    <div class="row pt-4">
        <div class="col-12 font-bold">Subscription :</div>
        @if(!$user->is_sub_cancel)
            <div class="col-12">
                <span><h3><span class="badge badge-success-lighten">{{ (isSubscriptionActive())?"Active":"Inactive"}}</span></h3></span>
            </div>
            <div class="col-12">
                <button class="btn btn-sm btn-danger cancel-sub" >Cancel Subscription</button>
            </div>
        @else
            <div class="col-12">
                <span><h3><span class="badge bg-danger">Cancelled</span></h3></span>
            </div>
        @endif
    </div>

    <div class="row pt-4">
        @if($user->pm_type)
        <div class="col-12 font-bold">Card Information:</div>
            <div class="col-12">
                <span><h3><span class="badge badge-info-lighten">{{ $user->pm_type }}</span></h3></span>
            </div>
            <div class="col-12">
                <span>********{{$user->pm_last_four}}</span>
            </div>
        
        @endif
    </div>

    <div class="row pt-4">
        <div class="col-12 font-bold">Referral Code:</div>
        <div class="col-12">
            <span id="referral_code_copy">{{ $user->referral_code }}</span> <button class="btn btn-sm btn-success" onclick="copyID()"><i class="mdi mdi-content-copy"></i></button>
        </div>
        <div class="col-12">
            <div class="page-title">
                <h4>Referral</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="referralTable" class="table table-hover dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>                                
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>
@endsection

@section('js')
	<script>
	    var addUrl = $('#profile-form').attr('action');
        var apiUrl = "{{ route('referral.list') }}";
        var cancelSubUrl = "{{ route('subscription.cancel') }}";
	    var page_reload = false;
	</script>
@endsection

@section('pagejs')
	<script src="{{asset('/js')}}/page/profile.js"></script>
@endsection