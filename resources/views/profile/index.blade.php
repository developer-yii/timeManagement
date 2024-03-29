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
                <div class="mb-3">
                    <label for="profilephoto" class="form-label">Profile Photo</label>
                    <input type="file" id="profilephoto" name="profilephoto" class="form-control">
                    <span class="error"></span>
                </div>
                <div id="preview">
                    @if($user->profilephoto)
                        <div class="form-group required row">
                        <div class="col-md-12 mb-2" id="img-prv">
                            <img id="preview-image" src="{{ url('/storage/uploads/profile\/').$user->profilephoto }}" alt="" style="max-height: 250px; max-width: 250px">
                        </div>
                        </div>
                    @endif
                </div>
        </div> <!-- end row -->       
        
        <div class="text-start">
            <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
        </div>
    </form>
    <div class="row pt-4">
    @if($user->user_type != 1)
        <div class="col-12 font-bold">Subscription :</div>
        @if($user->promocode_id)
            <div class="col-12 font-bold">Promo Subscription: <span class="badge badge-success-lighten">Active</span></div>
        @elseif($user->onTrial())
            <div class="col-12 font-bold">Trial Subscription: <span class="badge badge-success-lighten">Active</span></div>
            <div>Trial Ends At: <span class="badge badge-dark-lighten rounded-pill">{{ $user->trial_ends_at }}</span></div>
            <div><a href="{{ route('plans.index') }}" class="btn btn-success mt-2">Subscribe Here</a></div>
        @elseif(!$user->is_sub_cancel)
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
    {{-- @if($user->onTrial())
    <div class="row pt-4">
        <div class="col-12 font-bold">Trial Subscription: <span class="badge badge-success-lighten">Active</span></div>
        <div>Trial Ends At: <span class="badge badge-dark-lighten rounded-pill">{{ $user->trial_ends_at }}</span></div>
    </div>
    @endif --}}

    <div class="row pt-4">
        @if($user->pm_type)
        <div class="col-12 font-bold">Card Information:</div>
            <div class="col-12">
                <span><h3><span class="badge badge-info-lighten">{{ $user->pm_type }}</span></h3></span>
            </div>
            <div class="col-12">
                <span>********{{$user->pm_last_four}}</span>
            </div>
            
            <div class="col-12 mt-2">
                <p>To modify your payment method.
                Please login to our stripe dashboard using this link: <a href="{{ env('STRIPE_USER_LINK')}}" target="_blank">Stripe Link</a></p>
            </div>
        
        @endif
    </div>
    @endif

    @if($user->user_type == 4)
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
    @endif
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
	<script src="{{asset('/js')}}/page/profile.js?{{time()}}"></script>
@endsection