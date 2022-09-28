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
                <div class="row mb-2">
                    <div class="col-xl-3">
                       <div class="text-xl-start mt-xl-0 mt-2">
                           <button type="button" class="btn btn-green mb-2 me-2 add-new" data-bs-toggle="modal" data-bs-target="#add-modal"> Add Student Time/Activity</button>
                           
                       </div>
                   </div><!-- end col-->
                   <div class="col-xl-9">
                       <form id="search-form" class="row gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" action="{{route('student-time-log')}}" method="GET">                           
                           <div class="col-auto">
                               <div class="d-flex align-items-center">
                                   <label for="subject-select" class="me-2">Student</label>
                                   <select class="form-select" id="student-select" name="st">
                                       <option value="0" @if(empty($student)) selected @endif>Choose...</option>
                                        @foreach($student_list as $key => $value)
                                            <option value="{{$key}}" @if($student == $key) selected @endif>{{$value}}</option>
                                        @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-6">
                               <div class="d-flex align-items-center">
                                   <label for="subject-select" class="me-2">Subject</label>
                                   <!-- Multiple Select -->
                                    <select class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ..." name="sub[]" id="subject-select">      
                                        @foreach($subject_list as $key => $value)
                                            <option value="{{$key}}" @if ($subjects){{ (in_array($key, $subjects) ? "selected":"") }}@endif>{{$value}}</option>                                        
                                        @endforeach
                                    </select>
                               </div>
                           </div>
                           <div class="col-auto">
                                <div class="d-flex align-items-center button-list">
                                    <button type="submit" class="btn btn-green"> <i class="dripicons-search"></i></button>
                                    <button type="reset" class="btn btn-warning reset-form"> <i class="dripicons-clockwise"></i></button>
                                </div>
                            </div>
                       </form>                            
                   </div>
                   
               </div>
                <div class="row">
                    <div class="col-lg-12">
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
<div id="add-modal" class="modal fade" {{-- tabindex="-1" --}} role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header">
                <h4 class="modal-title"><span class="modal-lable-class" id="add-form-lable">Add</span></h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
            <form id="add-form" method="post" class="ps-3 pe-3" action="{{route('student-time-log.addupdate')}}" autocomplete="off">
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
                    <label class="form-label">Start time <i>(click clock button to the right)</i></label>
                    {{-- <div class="input-group"> --}}
                        <input id="start_time" name="start_time" type="time" value="08:56 AM" class="form-control" autocomplete="off">
                        {{-- <span class="input-group-text"><i class="dripicons-clock"></i></span> --}}
                    {{-- </div> --}}
                </div>
                <div class="mb-3">
                    <label class="form-label">End time <i>(click clock button to the right)</i></label>
                    {{-- <div class="input-group"> --}}
                        <input id="end_time" name="end_time" type="time" value="09:00 AM" class="form-control" autocomplete="off">
                        {{-- <span class="input-group-text"><i class="dripicons-clock"></i></span> --}}
                    {{-- </div> --}}
                </div>
                <div class="mb-3 d-none">
                    <label for="log_time" class="control-label">Log Time:</label>
                    <div class="input-group">
                        <input type="time" name="log_time" id="log_time" class="form-control" readonly>
                        <span class="input-group-text"><i class="dripicons-clock"></i></span>
                    </div>
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" id="attendance" name="attendance" class="form-check-input">
                        <label for="attendance" class="form-check-label">Attended: <i>(this will count toward your daily attendance)</i></label>
                    </div>
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="name" class="control-label">Activity/Notes:</label>
                    <textarea class="form-control" name="activity_notes" id="activity_notes" rows="5"></textarea>
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

<div id="edit-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title"><span class="modal-lable-class">View/Edit Holiday</h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>

            <div class="modal-body">
            <form id="edit-form" method="post" class="ps-3 pe-3" action="{{ route('holiday.update')}}">
                @csrf
                <input type="hidden" name="id" value="" id="edit-id">
                <div id="add_error_message"></div>
                
                <div class="mb-3" >
                    <label for="student_id" class="control-label">Student:</label>                    
                        <div class="flex" id="edit_modal">                        
                        </div>
                    <span class="error student_id"></span>
                </div>
                <div class="mb-3">
                    <label for="edit_start_date" class="control-label">Start Date:</label>
                    <input type="text" class="form-control date" id="edit_start_date" data-provide="datepicker" data-single-date-picker="true" name="start_date" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="edit_end_date" class="control-label">End Date:</label>
                    <input type="text" class="form-control date" id="edit_end_date" data-provide="datepicker" data-single-date-picker="true" name="end_date" data-date-format="yyyy-mm-dd">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="edit_event_color" class="control-label">Event Color:</label>
                    <input type="text" class="form-control" name="event_color" id="edit_event_color" data-coloris value="#fa5c7c">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="edit_note" class="control-label">Notes:</label>
                    <textarea class="form-control" name="note" id="edit_note" rows="5"></textarea>
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

<!-- /.modal -->
{{-- <div id="edit-log-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header">
                <h4 class="modal-title"><span class="modal-lable-class">Edit</span> {{$lable}}</h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
            <form id="edit-form" method="post" class="ps-3 pe-3" action="{{route('student-time-log.addupdate')}}">
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
                        <input id="start_time1" name="start_time" type="time" class="form-control">
                        <span class="input-group-text"><i class="dripicons-clock"></i></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">End time</label>
                    <div class="input-group">
                        <input id="end_time1" name="end_time" type="time" class="form-control">
                        <span class="input-group-text"><i class="dripicons-clock"></i></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="log_time" class="control-label">Log Time:</label>
                    <div class="input-group">                    
                        <input type="time" name="log_time" id="edit_log_time" class="form-control" readonly>
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

                <div class="mb-3 text-center">
                    <button class="btn btn-primary" type="submit">Save changes</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>                
            </form>
                </div>
        </div>
    </div>
</div> --}}
@endsection

@section('js')
<script src="{{ asset('js/vendor/coloris.js') }}"></script>
<script>
    var data_json = {!! $data_json !!};
    var apiUrl = "{{ route('student-time-log.list') }}";
    var detailUrl = "{{ route('student-time-log.detail') }}";
    var holidayDetailUrl = "{{ route('holiday.detail') }}";
    var deleteUrl = "{{ route('student-time-log.delete') }}";    
    var addUrl = $('#add-form').attr('action');
    var editUrl = $('#edit-form').attr('action');
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
    <link rel="stylesheet" href="{{ asset('css/vendor/coloris.css') }}" />
    <link href="{{ asset('css/vendor/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/page/student-time-log.css') }}" rel="stylesheet" type="text/css" />
@endsection