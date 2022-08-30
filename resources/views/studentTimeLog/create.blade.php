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
                    <li class="breadcrumb-item active">Create {{$lable}}</li>
                </ol>
            </div>
            <h4 class="page-title">Create {{$lable}}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="flash-message"></div>
                        <div class="mt-4 mt-lg-0">
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
                                <label class="form-label">Start time</label>
                                <div class="input-group">
                                    <input id="start_time" name="start_time" type="time" value="08:56 AM" class="form-control">
                                    <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End time</label>
                                <div class="input-group">
                                    <input id="end_time" name="end_time" type="time" value="09:00 AM" class="form-control">
                                    <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="log_time" class="control-label">Log Time:</label>
                                <div class="input-group">
                                    <input type="time" name="log_time" id="log_time" class="form-control" readonly>
                                    <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                </div>
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
                            <div class="mb-3 text-right">
                                <button class="btn btn-primary" type="submit">Save changes</button>                                
                            </div>                
                        </form>
                        </div>
                    </div> <!-- end col -->

                </div> <!-- end row -->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>
    <!-- end col-12 -->
</div> <!-- end row -->

@endsection

@section('js')
<script>
    var addUrl = $('#add-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')

<script src="{{asset('/js')}}/page/createTimeLog.js"></script>
@endsection

@section('css')
    
@endsection