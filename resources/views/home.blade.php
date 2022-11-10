@extends('layouts.app')

@section('content')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    {{-- @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif --}}
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="col-md-6 page-title-right">
                    <form class="d-flex">                        
                        {{-- <div class="col-md-6"> --}}
                        <label for="status-select" class="me-2">Student</label>
                        <select class="form-control select2" data-toggle="select2" id="student-select" name="s">
                            {{-- <option value="">Select Student</option> --}}
                            @foreach($students as $key => $value) 
                                <option value="{{$key}}" {{($key == $s)?"selected":""}}>{{$value}}</option>
                            @endforeach                            
                        </select>
                        <label for="status-select" class="me-2 ml-10">Year</label>
                        
                        <select class="form-control select2" data-toggle="select2" id="year-select" name="y">
                            @foreach(config('years') as $key => $value)
                                <option value="{{$key}}" {{($key == $y)?"selected":""}}>{{$value}}</option>
                            @endforeach                            
                        </select>
                        {{-- </div> --}}
                        <button type="submi" class="btn btn-green ml-10">Update</button>
                    </form>
                </div>
                <div class="col-md-6 d-flex">
                    <h4 class="page-title">Dashboard</h4>
                    <a href="javascript:void(0)" data-serialtip="ex1"><img src="{{asset('images/tooltip.png')}}" class="bulb-icon"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-centered mb-0 font-14">                            
                            <tbody>
                                <tr>
                                    <td>Core Hours</td>
                                    <td>{{($coreHours)?$coreHours:"00:00"}}</td>
                                    <td>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: 65%; height: 20px;" aria-valuenow="65"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Non-Core Hours</td>
                                    <td>{{($nonCoreHours)?$nonCoreHours:"00:00"}}</td>
                                    <td>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: 45%; height: 20px;" aria-valuenow="45"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hours Completed</td>
                                    <td>{{($hoursCompleted)?$hoursCompleted:"00:00"}}</td>
                                    <td>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-warning" role="progressbar"
                                                style="width: 30%; height: 20px;" aria-valuenow="30"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hours Required</td>
                                    <td>{{$hours_required}}:00</td>
                                    <td>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: 25%; height: 20px;" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hours Still Needed</td>
                                    <td>{{ timeDiffHHmm($hoursCompleted,$hours_required.":00")}}</td>
                                    <td>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: 25%; height: 20px;" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Attendance</td>
                                    <td>{{ ($attendance)?$attendance:'0'}}</td>
                                    <td>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: 25%; height: 20px;" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-bold">Attendance Needed</td>
                                    <td>{{ $attendance_required }}</td>
                                    <td>
                                        <div class="progress" style="height: 3px;">
                                            <div class="progress-bar bg-danger" role="progressbar"
                                                style="width: 25%; height: 20px;" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-1 mb-3">Core Subjects</h4>

                    <div class="table-responsive">
                        <table class="table table-sm table-centered mb-0 font-14">
                            <thead class="table-light">
                                <tr>
                                    <th>Core</th>
                                    <th>Time</th>
                                    <th style="width: 40%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($coreSubjects)
                                @foreach($coreSubjects as $key => $value)
                                    <tr>
                                        <td>{{$value->subject_name}}</td>
                                        <td>{{secToHHmm($value->time)}}</td>
                                        <td>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{getWidth($value->time,$maxCore)}}%; height: 20px;" aria-valuenow="{{$key}}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif                                
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-1 mb-3">Non-Core Subjects</h4>

                    <div class="table-responsive">
                        <table class="table table-sm table-centered mb-0 font-14">
                            <thead class="table-light">
                                <tr>
                                    <th>Non-Core</th>
                                    <th>Time</th>
                                    <th style="width: 40%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($nonCoreSubjects)
                                @foreach($nonCoreSubjects as $key => $value)
                                    <tr>
                                        <td>{{$value->subject_name}}</td>
                                        <td>{{secToHHmm($value->time)}}</td>
                                        <td>
                                            <div class="progress" style="height: 3px;">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{getWidth($value->time,$maxNonCore)}}%; height: 20px;" aria-valuenow="{{$key}}"
                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Attendance</h4>                        
                    </div>
                    <div id="chart">
                    </div>                    
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-lg-2">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Hours</h4>                        
                    </div> --}}
                    <div class="row">
                        <div class="text-left">
                            Hours
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-left">
                            <img src="{{asset('/images/downArrow.png')}}" style="height:60px">
                        </div>
                    </div>
                    <div class="row">
                        <div class="font-40">{{($hoursCompleted)?$hoursCompleted:"00:00"}}</div>
                    </div>
                    <div class="row">
                        <div class="text-right arrow-right">
                            <img src="{{asset('/images/upArrow.png')}}" style="height:60px">
                        </div>
                    </div>  
                    <div class="row">
                        <div class="text-right">
                            Minutes
                        </div>
                    </div>
                    
                    <div></div>
                    
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Total Hours Chart</h4>                        
                    </div>
                    <div id="column-chart-totalHours">
                    </div>                              
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Hour Progress & Goal</h4>
                    <div id="hour-progress"></div>
                        {{-- <div id="image-fill-bar" class="apex-charts" data-colors="#10c469,#ff5b5b,#e3eaef"></div>
                    </div> --}}
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Core Hours vs. Non-Core Hours</h4>
                    <div id="core-nonCore">
                        
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->
    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Core Subjects</h4>
                    <div id="core-subjects"></div>
                        {{-- <div id="image-fill-bar" class="apex-charts" data-colors="#10c469,#ff5b5b,#e3eaef"></div>
                    </div> --}}
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Non-Core Subjects</h4>
                    <div id="nonCore-subjects">
                        
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->
    </div>
    <!-- end row-->

</div>
<!-- container -->

<div data-serialtip-target="ex1" class="serialtip-default">
    <span class="serialtip-close"></span>
    <h5 class="serialtip-title">Welcome to Homeschool Minutes Progress Charts!</h5>
    <p>See all your stats quickly for each child or family member.</p>
    <p>This page will automatically keep track of hours, attendance, and the amount of time you spend on certain subjects.</p>
    <p>This is the perfect tool to help make sure you are getting all your state requirements in or just to have peace of mind that your chosen curriculum is giving your child everything they need.</p>
    <p>** You will be amazed at how much time you invest into homeschooling that you may not account for when estimating or recalling your times.</p>
</div>

@endsection
@section('css')
<link href="{{ asset('css/vendor/apexcharts.css') }}?{{time()}}" rel="stylesheet">
<link href="{{ asset('css/page/home-custom.css') }}?{{time()}}" rel="stylesheet">
@endsection

@section('js')
{{-- <script src="{{ asset('js/vendor/coloris.js') }}"></script> --}}
<script>
    var attendance = "{{$attendanceArray}}";
    var stuHours = "{{$hoursHHArray}}";
    var stuBarHours = "{{$hoursHHBarArray}}";
    var stuCoreNonCore = "{{$hourCoreNonCoreArray}}";
    var sesMessage = "{{ session()->get('success') }}";

    var coreSubjectsColumn = @json($coreSubjectsColumn);
    var coreSubjectsTimeColumn = @json($coreSubjectsTimeColumn);
    var nonCoreSubjectsColumn = @json($nonCoreSubjectsColumn);
    var nonCoreSubjectsTimeColumn = @json($nonCoreSubjectsTimeColumn);

    coreSubjectsColumn = JSON.parse(coreSubjectsColumn);
    coreSubjectsTimeColumn = JSON.parse(coreSubjectsTimeColumn);
    nonCoreSubjectsColumn = JSON.parse(nonCoreSubjectsColumn);
    nonCoreSubjectsTimeColumn = JSON.parse(nonCoreSubjectsTimeColumn);    

    attendance = JSON.parse(attendance);    
    stuHours = JSON.parse(stuHours);
    stuBarHours = JSON.parse(stuBarHours);
    stuCoreNonCore = JSON.parse(stuCoreNonCore);    
    
</script>
@endsection

@section('pagejs')
<script src="{{asset('/js')}}/page/home.js"></script>
@endsection
