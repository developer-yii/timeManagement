@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/page/promocode-index.css') }}?{{time()}}" />
@endsection

@section('content')
@php
$lable = "Promo Code";

@endphp
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Promo Code List</li>
                </ol>
            </div>
            <h4 class="page-title">Promo Code List</h4>
        </div>
    </div>
</div> 


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="text-right">
                    <button type="button" class="btn btn-green mb-2 add-new" data-bs-toggle="modal" data-bs-target="#add-modal">Add {{$lable}}</button>
                    </div>
                </div>
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="promoTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>{{$lable}}</th>
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
<!-- /.modal -->
<div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header">
                <h4 class="modal-title"><span class="modal-lable-class">Add</span> {{$lable}}</h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form id="add-form" method="post" class="ps-3 pe-3" action="{{route('promocode.addupdate')}}">
                    @csrf
                    <input type="hidden" name="id" value="0" id="edit-id">
                    <div id="add_error_message"></div>
                    
                    <label for="name" class="control-label">Promo Code:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="promocode" name="promocode">
                        <button class="btn btn-outline-secondary generate" type="button">Generate</button>
                        <button class="btn btn-outline-secondary copy" type="button" onclick="copyID()">Copy</button>
                    </div>
                    <div class="mb-3">
                        <span class="error"></span>
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-green" type="submit">Save changes</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/vendor/coloris.js') }}?{{time()}}"></script>
<script>
    var apiUrl = "{{ route('promocode.list') }}";
    var detailUrl = "{{ route('promocode.detail') }}";
    var deleteUrl = "{{ route('promocode.delete') }}";
    var generateUrl = "{{ route('promocode.generate') }}";
    var addUrl = $('#add-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')
<script src="{{asset('/js')}}/page/promocode.js?{{time()}}"></script>
@endsection