@extends('layouts.plan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex center-card">
            <div class="">
                <p>You will be charged ${{ number_format($plan->cost, 2) }} for {{ $plan->name }} Plan</p>
            </div>
            <div class="card" style="width: 30rem;">
                <form action="{{ route('subscription.create') }}" method="post" id="payment-form" data-secret="{{ $intent->client_secret }}">
                    @csrf                    
                    <div class="form-group">
                        <div class="card-header">
                            <label for="card-element">
                                Enter your credit card information
                            </label>
                        </div>
                        <div class="card-body">
                            <input type="text" id="card-holder-name" placeholder="Card Holder Name" class="form-control mb-3">
                            <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                            </div>
                            <!-- Used to display form errors. -->
                            <div id="card-errors" role="alert"></div>
                            <input type="hidden" name="plan" value="{{ $plan->id }}" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="submitBtn" type="submit">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay now</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/page/plans-show.css') }}?{{time()}}" rel="stylesheet">
@endsection

@section('pagejs')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Create a Stripe client.
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');

</script>
<script src="{{asset('/js')}}/page/plan-show.js?{{time()"></script>
@endsection