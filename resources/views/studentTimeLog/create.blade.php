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
                                <label class="form-label">Hours <i>(Enter Hours)</i></label>
                                {{-- <div class="input-group"> --}}
                                    <input id="hrs" name="hrs" type="number" step="1" min="0"class="form-control">
                                    {{-- <span class="input-group-text"><i class="dripicons-clock"></i></span> --}}
                                {{-- </div> --}}
                                <span class="error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Minutes <i>(Enter Minutes)</i></label>
                                {{-- <div class="input-group"> --}}
                                    <input id="minutes" name="minutes" type="number" step="1" min="0" class="form-control">
                                    {{-- <span class="input-group-text"><i class="dripicons-clock"></i></span> --}}
                                {{-- </div> --}}
                                <span class="error"></span>
                            </div>
                            {{-- <div class="mb-3 d-none">
                                <label for="log_time" class="control-label">Log Time:</label>
                                <div class="input-group">
                                    <input type="time" name="log_time" id="log_time" class="form-control" readonly>
                                    <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                </div>
                                <span class="error"></span>
                            </div> --}}

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" id="attendance" name="attendance" class="form-check-input">
                                    <label for="attendance" class="form-check-label">Attended: <i>(this will count toward your daily attendance)</i></label>
                                </div>
                                <span class="error"></span>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" id="completed" name="completed" class="form-check-input">
                                    <label for="completed" class="form-check-label">Completed: <i>(calendar will feature a black checkmark)</i></label>
                                </div>
                                <span class="error"></span>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="control-label">Activity/Notes:</label>
                                <textarea class="form-control" name="activity_notes" id="activity_notes" rows="5"></textarea>
                                <span class="error"></span>
                            </div>

                            <div class="mb-1">
                                <label for="formFileMultiple" class="form-label">Upload Files <i>(Pictures,Sample of work, Projects, Worksheets)</i></label>
                                <input class="form-control" type="file" id="formFileMultiple" name="formFileMultiple[]" multiple>
                                <span class="error formFileMultiple"></span>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex" id="ufiles">
                                    
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label for="links" class="control-label">Link Name:</label>                            
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="address" class="control-label">Link Address:</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row linkrow">
                                    @php $temp = '';@endphp
                                    <div class="col-sm-5">                            
                                        <select name="links[]" id="links" class="form-control links">
                                            @foreach($links as $lkey => $link)
                                                @if($lkey == '0')                                
                                                   @php $temp = $link->link; @endphp
                                                @endif
                                                    <option value="{{ $link->id }}">{{ $link->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" name="address[]" value="{{ $temp }}" readonly>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-danger"
                                            id="DeleteRow" type="button">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div id="newinput"></div>
                            <div class="row">
                                <div class="col-sm-10">
                                    
                                </div>
                                <div class="col-md-2">
                                <button id="rowAdder" type="button"
                                    class="btn btn-dark">
                                    <i class="mdi mdi-plus">
                                    </i> 
                                </button>
                                </div>
                            </div>

                            <div class="mb-3 text-right mt-3">
                                <button class="btn btn-green" type="submit">Save changes</button>                                
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
    var getLinkUrl = "{{ route('get.link') }}";
    var linkhtml = $('.linkrow').html();
    var page_reload = false;
</script>
@endsection

@section('pagejs')

<script src="{{asset('/js')}}/page/createTimeLog.js?{{time()}}"></script>
@endsection

@section('css')
    
@endsection