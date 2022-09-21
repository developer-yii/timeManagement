@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/vendor/coloris.css') }}" />
@endsection

@section('content')
@php
$lable = "User";

@endphp
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$lable}} List</li>
                </ol>
            </div>
            <h4 class="page-title">{{$lable}} List</h4>
        </div>
    </div>
</div> 


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">                
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="userTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Type</th>                                
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('modal')

@endsection

@section('js')
<script>
    var apiUrl = "{{ route('users.list') }}";
    var loginUrl = "{{ route('user.login') }}";    
    var page_reload = false;
</script>
@endsection

@section('pagejs')
    <script src="{{asset('/js')}}/page/users.js"></script>
@endsection