@extends('layouts.plan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xxl-10">

            <!-- Pricing Title-->
            <div class="text-center">
                <h3 class="mb-2">Our Plans and Pricing</h3>
                {{-- <p class="text-muted w-50 m-auto">
                    We have plans and prices that fit your business perfectly. Make your client site a success with our products.
                </p> --}}
            </div>
            <!-- Plans -->
            <div class="row mt-sm-5 mt-3 mb-3 justify-content-center">
                @foreach($plans as $plan)
                    <div class="col-md-4">
                        <div class="card card-pricing">
                            <div class="card-body text-center">
                                <p class="card-pricing-plan-name fw-bold text-uppercase">{{ $plan->name }}</p>
                                <i class="card-pricing-icon dripicons-user text-primary"></i>
                                <h2 class="card-pricing-price">${{ number_format($plan->cost, 2) }} <span>/ Month</span></h2>
                                <ul class="card-pricing-features">
                                    <li>{{ $plan->description }}</li>                                    
                                </ul>
                                @if(!auth()->user()->subscribed($plan->name))
                                    <a href="{{ route('plans.show', $plan->slug) }}" class="btn btn-primary mt-4 mb-2 rounded-pill">Choose</a>
                                @endif
                                {{-- <button class="">Choose Plan</button> --}}
                            </div>
                        </div> <!-- end Pricing_card -->
                    </div> <!-- end col -->                   
                @endforeach
            </div>
            <!-- end row -->

        </div> <!-- end col-->
    </div>
    {{-- <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Plans</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($plans as $plan)
                        <li class="list-group-item clearfix">
                            <div class="pull-left">
                                <h5>{{ $plan->name }}</h5>
                                <h5>${{ number_format($plan->cost, 2) }} monthly</h5>
                                <h5>{{ $plan->description }}</h5>
                                @if(!auth()->user()->subscribed($plan->name))
                                    <a href="{{ route('plans.show', $plan->slug) }}" class="btn btn-outline-dark pull-right">Choose</a>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@section('pagejs')
<script type="text/javascript">
    var subMessage = "{{ session()->get('subMessage') }}";
    if(subMessage)
    {
        show_toast(subMessage, 'error');
    }
    
</script>
@endsection