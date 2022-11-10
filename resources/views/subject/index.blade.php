@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/vendor/coloris.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/page/subject-index.css') }}" />
@endsection

@section('content')
@php
$lable = "Subject";

@endphp
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active">Subject/Activity List</li>
                </ol>
            </div>
            <h4 class="page-title">Subject/Activity List</h4>
        </div>
    </div>
</div> 


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-green mb-2 add-new" data-bs-toggle="modal" data-bs-target="#add-modal">Add {{$lable}}</button><a href="javascript:void(0)" data-serialtip="ex1"><img src="{{asset('images/tooltip.png')}}" class="bulb-icon"></a>{{-- <img src="{{asset('images/bulb.png')}}" class="bulb-icon"><span class="font-bold">Add each subject, sport, and extracurricular your children/students may participate in. These subjects can also be classified as core or non-core.</span> --}}
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="subjectTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>{{$lable}} Name</th>
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
    <h5 class="serialtip-title">Welcome to Homeschool Minutes Subject/Activity List!</h5>
    <p>This will give you a complete list of all the subjects/activities you have entered in the Monthly Planner Calendar.</p>
    <p>Names can be color coded.</p>
    <p>** Anything that will be tracked through either core or non-core hours when entering time spent. Example: Drums, History, Dance Class, Spanish….</p>
</div>

<!-- /.modal -->
<div id="add-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title"><span class="modal-lable-class">Add</span> {{$lable}}</h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>

            <div class="modal-body">
            <form id="add-form" method="post" class="ps-3 pe-3" action="{{route('subject.addupdate')}}">
                @csrf
                <input type="hidden" name="id" value="0" id="edit-id">
                <div id="add_error_message"></div>
                
                <div class="mb-3">
                    <label for="name" class="control-label">Name:</label>
                    <input type="text" class="form-control" id="subject_name" name="subject_name"> <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="subject_type" class="control-label">Subject Type:</label>
                    <select name="subject_type" id="subject_type" class="form-control">
                        <option value="">Select Subject Type</option>
                        <option value="1">Core</option>
                        <option value="2">Non Core</option>
                    </select>
                    <span class="error"></span>
                </div>

                {{-- <div class="mb-3">
                    <label for="subject_color" class="control-label">Event Color:</label>
                    <input type="text" class="form-control" name="subject_color" id="subject_color" data-coloris value="#727cf5">
                    <span class="error"></span>
                </div> --}}
                
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
<script src="{{ asset('js/vendor/coloris.js') }}"></script>
<script>
    var apiUrl = "{{ route('subject.list') }}";
    var detailUrl = "{{ route('subject.detail') }}";
    var deleteUrl = "{{ route('subject.delete') }}";
    var addUrl = $('#add-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')
<script src="{{asset('/js')}}/page/subject.js"></script>
@endsection