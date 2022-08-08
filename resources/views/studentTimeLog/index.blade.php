@extends('layouts.app')

@section('content')
@php
$lable = "Student Time Log";

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
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-warning mb-2 add-new" data-bs-toggle="modal" data-bs-target="#add-modal">Add Log</button>
                        <div id="flash-message"></div>
                        <div class="mt-4 mt-lg-0">
                            <div id="calendar"></div>
                        </div>
                    </div> <!-- end col -->

                </div> <!-- end row -->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>
    <!-- end col-12 -->
</div> <!-- end row -->

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
            <form id="add-form" method="post" class="ps-3 pe-3" action="{{route('student-time-log.addupdate')}}">
                @csrf
                <input type="hidden" name="id" value="0" id="edit-id">
                <div id="add_error_message"></div>
                
                <div class="mb-3">
                    <label for="student_id" class="control-label">Student:</label>
                    <select name="student_id" id="student_id" class="form-control">
                        <option value="">Select Student</option>
                        @foreach($student_list as $stkey=>$stlist)
                            <option value="{{ $stkey }}">{{ $stlist }}</option>
                        @endforeach
                    </select>
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="subject_id" class="control-label">Subject:</label>
                    <select name="subject_id" id="subject_id" class="form-control">
                        <option value="">Select Subject</option>
                        @foreach($subject_list as $sukey=>$sulist)
                            <option value="{{ $sukey }}">{{ $sulist }}</option>
                        @endforeach
                    </select>
                    <span class="error"></span>
                </div>
                
                <div class="mb-3">
                    <label for="name" class="control-label">Select Date:</label>
                    <input type="text" class="form-control date" id="log_date" data-toggle="date-picker" data-single-date-picker="true" name="log_date">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="log_time" class="control-label">Log Time:</label>
                    <select name="log_time" id="log_time" class="form-control">
                        <option value="">Select Log Time</option>
                        <option value="5">00.05</option>
                        <option value="10">00.10</option>
                        <option value="15">00.15</option>
                        <option value="20">00.20</option>
                        <option value="25">00.25</option>
                        <option value="30">00.30</option>
                        <option value="35">00.35</option>
                        <option value="40">00.40</option>
                        <option value="45">00.45</option>
                        <option value="50">00.50</option>
                        <option value="55">00.55</option>
                        <option value="60">01.00</option>
                        <option value="75">01.15</option>
                        <option value="90">01.30</option>
                        <option value="105">01.45</option>
                        <option value="120">02.00</option>
                        <option value="180">03.00</option>
                        <option value="240">04.00</option>
                        <option value="300">05.00</option>
                        <option value="360">06.00</option>
                    </select>
                    <span class="error"></span>
                </div>


                <div class="mb-3">
                    <label for="name" class="control-label">Attendance:</label>
                    <input type="checkbox" id="attendance" name="attendance">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="name" class="control-label">Activity/Notes:</label>
                    <textarea class="form-control" name="activity_notes" id="activity_notes" rows="5"></textarea>
                    <span class="error"></span>
                </div>

                <div class="mb-3 text-center">
                    <button class="btn btn-primary" type="submit">Save changes</button>
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
    var data_json = {!! $data_json !!};
    var apiUrl = "{{ route('student-time-log.list') }}";
    var detailUrl = "{{ route('student-time-log.detail') }}";
    var deleteUrl = "{{ route('student-time-log.delete') }}";
    var addUrl = $('#add-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')
<!-- third party js -->
<script src="{{ asset('js/vendor/fullcalendar.min.js') }}"></script>
<!-- third party js ends -->

<!-- demo app -->
<script src="{{ asset('js/vendor/demo.calendar.js') }}"></script>
<!-- end demo js-->

<script src="{{asset('/js')}}/page/studentTimeLog.js"></script>
@endsection

@section('css')
    <!-- third party css -->
    <link href="{{ asset('css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
@endsection