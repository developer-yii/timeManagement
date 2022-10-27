@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/vendor/coloris.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/page/student-index.css') }}" />
@endsection

@section('content')
@php
$lable = "Student";

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
                <button type="button" class="btn btn-green mb-2 add-new" data-bs-toggle="modal" data-bs-target="#add-modal">Add {{$lable}}</button><a href="javascript:void(0)" data-serialtip="student-tooltip"><img src="{{asset('images/tooltip.png')}}" class="bulb-icon"></a>{{-- <img src="{{asset('images/bulb.png')}}" class="bulb-icon"><span class="font-bold">Add all children, even those not attending school. You will still be able to keep track of projects, schedules, doctor's appointments, and more.</span> --}}
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="studentTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Grade</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Color</th>
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
<div data-serialtip-target="student-tooltip" class="serialtip-default">
    <span class="serialtip-close"></span>
    <h5 class="serialtip-title">Popover Example</h5>
    <p>Tooltips and popovers are two very commonly used, customizable, interactive visual elements in creating websites and web applications.</p>
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
            <form id="add-form" method="post" class="ps-3 pe-3" action="{{route('student.addupdate')}}">
                @csrf
                <input type="hidden" name="id" value="" id="edit-id">
                <div id="add_error_message"></div>
                
                <div class="mb-3">
                    <label for="first_name" class="control-label">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"> 
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="control-label">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"> 
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="email" class="control-label">Email:</label>
                    <input type="text" class="form-control" id="email" name="email"> 
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="phone" class="control-label">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone"> 
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="attendance" class="control-label">Attendance Days Required:<i> (Please put 0 if this is not required)</i></label>
                    <input type="number" step="1" class="form-control" id="attendance" name="attendance"> 
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="hours" class="control-label">Hours Required:<i> (Please put 0 if this is not required)</i></label>
                    <input type="number" step="1" class="form-control" id="hours" name="hours"> 
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="student_color" class="control-label">Color:</label>
                    <input type="text" class="form-control" name="student_color" id="student_color" data-coloris value="#727cf5">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="phone" class="control-label">Grade Level:</label>
                    <select id="grade_level" name="grade_level" class="form-control">
                        <option value=""> -- Select Grade --</option>
                        @foreach($gradeLevels as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
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
<script src="{{ asset('js/vendor/coloris.js') }}"></script>
<script>
    var apiUrl = "{{ route('student.list') }}";
    var detailUrl = "{{ route('student.detail') }}";
    var deleteUrl = "{{ route('student.delete') }}";
    var addUrl = $('#add-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')
<script src="{{asset('/js')}}/page/student.js"></script>
@endsection