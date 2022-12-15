@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/page/file-index.css') }}?{{ time()}}" />    
@endsection

@section('content')
@php
$lable = "Saved Photo/Uploads";

@endphp
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">{{$lable}}</li>
                </ol>
            </div>
            <h4 class="page-title">{{$lable}}</h4>
        </div>
    </div>
</div> 


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- <button type="button" class="btn btn-green mb-2 add-new" data-bs-toggle="modal" data-bs-target="#add-modal">Add Link</button> --}}
                <a href="javascript:void(0)" data-serialtip="ex1"><img src="{{asset('images/tooltip.png')}}" class="bulb-icon"></a>{{-- <img src="{{asset('images/bulb.png')}}" class="bulb-icon"><span class="font-bold">Add each subject, sport, and extracurricular your children/students may participate in. These subjects can also be classified as core or non-core.</span> --}}
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="filesTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Subject</th>
                                <th>Files</th>
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

<div data-serialtip-target="ex1" class="serialtip-default">
    <span class="serialtip-close"></span>
    <h5 class="serialtip-title">Welcome to Homeschool Minutes Saved Photos/Uploads!</h5>
    <p>When you add your child’s time and upload a files/photos to that it will be added to this list so you can conveniently find and search for them.</p>
</div>

<!-- /.modal -->
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title"><span class="modal-lable-class">Edit photo</h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>

            <div class="modal-body">
                <form id="edit-form" method="post" class="ps-3 pe-3" action="">
                    @csrf
                    <input type="hidden" name="id" value="0" id="edit-id">
                    <div id="add_error_message"></div>

                    <div class="mb-3">
                        <label for="photo" class="control-label">Upload file:</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        <span class="error"></span>
                    </div>                

                    <div id="img-prv">                    
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

<script>
    var apiUrl = "{{ route('file.list') }}";
    var detailUrl = "{{ route('link.detail') }}";
    var deleteUrl = "{{ route('file.delete') }}";
    var updateUrl = "{{route('file.update')}}";
    var addUrl = $('#add-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')
<script src="{{asset('/js')}}/page/files.js?{{time()}}"></script>
@endsection