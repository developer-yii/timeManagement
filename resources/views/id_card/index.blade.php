@extends('layouts.app')

@section('content')
@php
$lable = "ID Card Emails";

@endphp
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $lable }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ $lable }}</h4>
        </div>
    </div>
</div> 


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="idcardTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>Email</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    var apiUrl = "{{ route('idcard.list') }}";
    var page_reload = false;
    var isPrint = false;
    var isCard = false;
</script>
@endsection

@section('pagejs')
<script src="{{asset('/js')}}/page/id-card.js?{{time()}}"></script>
@endsection