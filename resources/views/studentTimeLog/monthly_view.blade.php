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
                        <label for="student_id" class="control-label">Select Student:</label>
                        <select name="student_id" id="student_id" class="form-control">
                            <option value="">Select Student</option>
                            @foreach($student_list as $skey=>$slist)
                                <option value="{{ $skey }}">{{ $slist }}</option>
                            @endforeach
                        </select>
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
                    </div>    
                    <div class="col-3">
                        <label for="month" class="control-label">Select Month:</label>
                        <select name="month" id="month" class="form-control">
                            <option value="">Select Month</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>    
                    <div class="col-3">
                        <button class="btn btn-primary search_log mt-3">Search</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-warning mb-2 add-new mt-1" data-bs-toggle="modal" data-bs-target="#add-modal">Add Log</button>
                        <div id="flash-message"></div>
                        <div class="mt-4 mt-lg-0 table-responsive monthly_view_table">
                           <table> 
                                <thead>
                                    <td>Date</td>
                                    <td>Attendance</td>
                                    @foreach($subject_list as $slist)
                                        <td>{{ $slist['subject_name'] }}</td>
                                    @endforeach
                                </thead>
                                <tbody>
                                    <?php 
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
                                    ?>
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



@section('js')
<script>
    var apiUrl = "{{ route('student-time-log.list') }}";
    var detailUrl = "{{ route('student-time-log.detail') }}";
    var deleteUrl = "{{ route('student-time-log.delete') }}";
    var addUrl = $('#add-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')

<script src="{{asset('/js')}}/page/studentTimeLog.js"></script>

@endsection