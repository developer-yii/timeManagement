@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="change-price-form">
                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Change subscription Price</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="current_price" class="form-label">Current Subscription Price</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="basic-addon1">$</span>
                                <input type="text" class="form-control" placeholder="Username" aria-label="current_price" aria-describedby="basic-addon1" id="current_price" name="current_price" value="{{ $plan->cost }}" readonly>
                            </div>
                            {{-- <input type="text" class="form-control" id="current_price" name="current_price" value="{{ $plan->cost }}" readonly> --}}
                            <span class="error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">New Price ($)</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="basic-addon1">$</span>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter price" aria-label="price" aria-describedby="basic-addon1">
                            </div>
                            {{-- <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter price"> --}}
                            <span class="error"></span>
                        </div>
                    </div>
                </div> <!-- end row -->       
                
                <div class="text-start">
                    <button type="submit" class="btn btn-success mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                </div>
            </form>            
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/page/price-show.css') }}?{{time()}}" rel="stylesheet">
@endsection

@section('pagejs')
<script type="text/javascript">    
    var priceChangeUrl = "{{ route('subscription.price.change') }}";
</script>

<script src="{{asset('/js')}}/page/price-show.js?{{time()"></script>
@endsection