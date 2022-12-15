@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/vendor/coloris.css') }}?{{time()}}" />
    <link rel="stylesheet" href="{{ asset('css/page/holiday-index.css') }}?{{time()}}" />
@endsection

@section('content')
@php
    $lable = "Holidays/Events";
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
                <button type="button" class="btn btn-green mb-2 add-new" data-bs-toggle="modal" data-bs-target="#add-modal">Add {{$lable}}</button><a href="javascript:void(0)" data-serialtip="ex1"><img src="{{asset('images/tooltip.png')}}" class="bulb-icon"></a>{{-- <img src="{{asset('images/bulb.png')}}" class="bulb-icon"><span class="font-bold">Keep track of your homeschool schedule quickly and easily. Add holidays, days off, weekends, field trips & more!</span> --}}
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="holidayTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Event Date</th>
                                {{-- <th>End Date</th> --}}
                                <th>Note</th>
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

<div data-serialtip-target="ex1" class="serialtip-default">
    <span class="serialtip-close"></span>
    <h5 class="serialtip-title">Welcome to Homeschool Minutes Holiday/Events List!</h5>
    <p>This will give you a complete list of all the holiday/events you have entered in the Monthly Planner.</p>
    <p>Events can be color coded.</p>
    <p>** These items are not calculated in your hours.</p>
    <p>You can have two options:</p>
    <p>1. TWO ENTRIES. You can add an event (Drums 12:30-1:00pm), then add student time/activity of 30 minutes in drums. Since you can color code the events it helps it stand out from the rest as a reminder.</p>
    <p>2. ONE ENTRY. The Second option is to add the drum Lesson through the Add Student Time/Activity button on your planner only.</p>
    {{-- <p>Keep track of everything!</p> --}}
</div>

<!-- /.modal -->
<div id="add-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <h4 class="modal-title"><span class="modal-lable-class">Add</span> {{$lable}}</h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>

            <div class="modal-body">
            <form id="add-form" method="post" class="ps-3 pe-3" action="{{route('holiday.addupdate')}}">
                @csrf
                {{-- <input type="hidden" name="id" value="" id="edit-id"> --}}
                <div id="add_error_message"></div>
                
                <div class="mb-3" >
                    <label for="student_id" class="control-label">Student:</label>
                    {{-- <select name="student_id[]" id="student_id" class="form-control"> --}}
                        {{-- <option value="">Select Student</option> --}}
                        <div class="flex">
                            <div class="form-check">
                                <input type='checkbox' name='student_id' value="all" id="student_id_all" class="form-check-input"/>
                                <label class="form-check-label form-label" for="student_id_all">All</label>    
                            </div>
                        @foreach($student_list as $stkey=>$stlist)                                                    
                        <div class="form-check">
                            <input type='checkbox' name='student_id[]' value="{{ $stkey }}" id="student_id_{{ $stkey }}" class="form-check-input student-checkbox"/>
                            <label class="form-check-label form-label" for="student_id_{{ $stkey }}">{{ $stlist }}</label>
                        </div>
                        @endforeach
                        </div>
                    <span class="error student_id"></span>
                    {{-- </select> --}}
                    
                </div>

                {{-- <div class="mb-3">
                    <label for="start_date" class="control-label">Start Date:</label>
                    <input type="text" class="form-control date" id="start_date" data-provide="datepicker" data-single-date-picker="true" name="start_date" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="name" class="control-label">End Date:</label>
                    <input type="text" class="form-control date" id="end_date" data-provide="datepicker" data-single-date-picker="true" name="end_date" data-date-format="yyyy-mm-dd">
                    <span class="error"></span>
                </div> --}}

                <div class="mb-3">
                    <label for="event_date" class="control-label">Date:</label>
                    <input type="text" class="form-control date" id="event_date" data-provide="datepicker" name="event_date">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="event_color" class="control-label">Event Color:</label>
                    <input type="text" class="form-control" name="event_color" id="event_color" data-coloris value="#fa5c7c">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="note" class="control-label">Notes:</label>
                    <textarea class="form-control" name="note" id="note" rows="5"></textarea>
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
                <h4 class="modal-title"><span class="modal-lable-class">Add</span> {{$lable}}</h4> 
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>

            <div class="modal-body">
            <form id="edit-form" method="post" class="ps-3 pe-3" action="{{route('holiday.update')}}">
                @csrf
                <input type="hidden" name="id" value="" id="edit-id">
                <div id="add_error_message"></div>
                
                <div class="mb-3" >
                    <label for="student_id" class="control-label">Student:</label>
                        <div class="flex" id="edit_modal">
                        </div>
                    <span class="error student_id"></span>
                </div>

                {{-- <div class="mb-3">
                    <label for="edit_start_date" class="control-label">Start Date:</label>
                    <input type="text" class="form-control date" id="edit_start_date" data-provide="datepicker" data-single-date-picker="true" name="start_date" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="edit_end_date" class="control-label">End Date:</label>
                    <input type="text" class="form-control date" id="edit_end_date" data-provide="datepicker" data-single-date-picker="true" name="end_date" data-date-format="yyyy-mm-dd">
                    <span class="error"></span>
                </div> --}}

                <div class="mb-3">
                    <label for="edit_event_date" class="control-label">Date:</label>
                    <input type="text" class="form-control date" id="edit_event_date" data-provide="datepicker" name="event_date">
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
<script src="{{ asset('js/vendor/coloris.js') }}?{{time()}}"></script>
<script>
    var apiUrl = "{{ route('holiday.list') }}";
    var detailUrl = "{{ route('holiday.detail') }}";
    var deleteUrl = "{{ route('holiday.delete') }}";
    var addUrl = $('#add-form').attr('action');
    var updateUrl = $('#edit-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')
<script src="{{asset('/js')}}/page/holiday.js?{{time()}}"></script>
@endsection