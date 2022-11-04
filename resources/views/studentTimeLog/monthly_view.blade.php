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
                    <div class="col-3">
                    <form id="search-form" action="{{ route('student-time-log.search')}}">
                        @csrf
                        <label for="student_id" class="control-label">Select Student:</label>
                        <select name="student_id" id="student_id" class="form-control">
                            <option value="">Select Student</option>
                            @foreach($student_list as $skey=>$slist)
                                <option value="{{ $skey }}">{{ $slist }}</option>
                            @endforeach
                        </select>
                        <span class="error"></span>
                    </div>    

                    <div class="col-3">
                        <label for="year" class="control-label">Select Year:</label>
                        <select name="year" id="year" class="form-control">
                            <option value="">Select Year</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                        <span class="error"></span>
                    </div>    
                    <div class="col-3">
                        <label for="month" class="control-label">Select Month:</label>
                        <select name="month" id="month" class="form-control">
                            <option value="">Select Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <span class="error"></span>
                    </div>    
                    <div class="col-3">
                        <button class="btn btn-green search_log mt-3" type="submit">Search</button>
                        <button class="btn btn-green mt-3 print-pdf" type="button">Print</button>
                    </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-lg-12" id="pdfs">
                        {{-- <button type="button" class="btn btn-warning mb-2 add-new mt-1" data-bs-toggle="modal" data-bs-target="#add-modal">Add Log</button> --}}
                        <div id="flash-message"></div>
                        <div class="mt-4 table-responsive monthly_view_table">
                           <table class="table table-striped table-centered mb-0"> 
                                <thead class="table-dark">
                                    <td>Date</td>
                                    <td>Attendance</td>
                                    @foreach($subject_list as $slist)
                                        <td>{{ $slist['subject_name'] }}</td>
                                    @endforeach
                                </thead>
                                <tbody id="logData">
                                    {{-- <?php 
                                        for($i=1;$i<=$days;$i++){
                                    ?>
                                        <tr>
                                            <td>{{ $i.'-'.$month.'-'.$year }}</td>
                                            <td>0</td>
                                            @foreach($subject_list as $slist)
                                                <td>
                                                    <?php 
                                                        $s_s_date = '2-'.$slist['id'].'-'.$i;

                                                        if(isset($student_log_data[$s_s_date])){
                                                            echo gmdate("H:i", $student_log_data[$s_s_date]*60);
                                                        }else{
                                                            echo '00:00';
                                                        }
                                                    ?>
                                                </td>
                                            @endforeach
                                        </tr>
                                    <?php        
                                        }
                                    ?> --}}
                                </tbody>
                           </table>
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
<div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        @foreach($subject_list as $sukey => $sulist)
                            <option value="{{ $sulist->id }}">{{ $sulist->subject_name }}</option>
                        @endforeach
                    </select>
                    <span class="error"></span>
                </div>
                
                <div class="mb-3">
                    <label for="name" class="control-label">Select Date:</label>
                    <input type="text" class="form-control date" id="log_date" data-toggle="date-picker" data-single-date-picker="true" name="log_date">
                    <span class="error"></span>
                </div>

                <!-- <div class="mb-3">
                    <label class="form-label">Start time</label>
                    {{-- <div class="input-group" id="timepicker-input-group4"> --}}
                        <input id="start_time1" name="start_time" type="time" class="form-control">
                        {{-- <span class="input-group-text"><i class="dripicons-clock"></i></span> --}}
                    {{-- </div> --}}
                    <span class="error"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label">End time</label>
                    {{-- <div class="input-group" id="timepicker-input-group5"> --}}
                        <input id="end_time1" name="end_time" type="time" class="form-control">
                        {{-- <span class="input-group-text"><i class="dripicons-clock"></i></span> --}}
                    {{-- </div> --}}
                    <span class="error"></span>
                </div>

                <div class="mb-3 d-none">
                    <label for="log_time" class="control-label">Log Time:</label>                    
                    <input type="time" name="log_time" id="log_time" class="form-control">
                    <span class="error"></span>
                </div> -->

                <div class="mb-3">
                    <div class="row abcd">
                        <div class="col-4">                            
                            <label class="form-label" for="hrs">Log Hrs {{-- <i>(Enter Hours)</i> --}}</label>
                            <input id="hrs" name="hrs" type="number" step="1" class="form-control" autocomplete="off">
                            <span class="error"></span>      
                        </div>
                        <div class="col-auto">
                            <p class="colon-hhmm">:</p>                            
                        </div>
                        <div class="col-4">
                            <label class="form-label" for="minutes">Log Minutes {{-- <i>(Enter Minutes)</i> --}}</label>
                            <input id="minutes" name="minutes" type="number" step="1" class="form-control" autocomplete="off">
                            <span class="error"></span>
                        </div>                        
                    </div>                        
                </div>


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
                <div class="text-right">
                    <button id="rowAdder" type="button"
                        class="btn btn-dark">
                        <i class="mdi mdi-plus">
                        </i> 
                    </button>
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
    var apiUrl = "{{ route('student-time-log.list') }}";
    var detailUrl = "{{ route('student-time-log.detail') }}";
    var deleteUrl = "{{ route('student-time-log.delete') }}";
    var appCssUrl = "{{ asset('css/app.min.css') }}";
    var customCssUrl = "{{ asset('css/custom.css') }}";
    var pdfdataUrl = "{{ route('pdfData')}}"
    var searchUrl = $('#search-form').attr('action');
    var editUrl = $('#edit-form').attr('action');
    var linkhtml = $('.linkrow').html();
    var getLinkUrl = "{{ route('get.link') }}";
    var page_reload = false;
</script>
@endsection

@section('pagejs')

<!-- demo app -->
{{-- <script src="{{ asset('js/vendor/demo.timepicker.js') }}"></script> --}}
<!-- end demo js-->

<script src="{{asset('/js')}}/page/studentMonthlyLog.js"></script>

@endsection

@section('css')
    <!-- page css -->    
    <link href="{{ asset('css/page/monthlyview.css') }}" rel="stylesheet" type="text/css" />
@endsection