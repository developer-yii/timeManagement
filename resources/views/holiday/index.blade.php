@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/vendor/coloris.css') }}" />
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
                <button type="button" class="btn btn-primary mb-2 add-new" data-bs-toggle="modal" data-bs-target="#add-modal">Add {{$lable}}</button><img src="{{asset('images/bulb.png')}}" class="bulb-icon"><span class="font-bold">keep track of your home school schedule quickly and easily! Add holiday, Days off, weekends and more.</span>
                <div id="flash-message"></div>
                <div class="table-responsive">
                    <table id="holidayTable" class="table table-hover dataTable">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Note</th>
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
                <input type="hidden" name="id" value="" id="edit-id">
                <div id="add_error_message"></div>
                
                <div class="mb-3">
                    <label for="student_id" class="control-label">Student:</label>
                    {{-- <select name="student_id[]" id="student_id" class="form-control"> --}}
                        {{-- <option value="">Select Student</option> --}}
                        <div class="flex">
                        @foreach($student_list as $stkey=>$stlist)                                                    
                        <div class="form-check">
                            <input type='checkbox' name='student_id[]' value="{{ $stkey }}" id="student_id_{{ $stkey }}" class="form-check-input"/>
                            <label class="form-check-label form-label" for="student_id_{{ $stkey }}">{{ $stlist }}</label>
                        </div>
                        @endforeach
                        </div>
                    <span class="error student_id"></span>
                    {{-- </select> --}}
                    
                </div>

                <div class="mb-3">
                    <label for="start_date" class="control-label">Start Date:</label>
                    <input type="text" class="form-control date" id="start_date" data-provide="datepicker" data-single-date-picker="true" name="start_date" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                    <span class="error"></span>
                </div>

                <div class="mb-3">
                    <label for="name" class="control-label">End Date:</label>
                    <input type="text" class="form-control date" id="end_date" data-provide="datepicker" data-single-date-picker="true" name="end_date" data-date-format="yyyy-mm-dd">
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
<script src="{{ asset('js/vendor/coloris.js') }}"></script>
<script>
    var apiUrl = "{{ route('holiday.list') }}";
    var detailUrl = "{{ route('holiday.detail') }}";
    var deleteUrl = "{{ route('holiday.delete') }}";
    var addUrl = $('#add-form').attr('action');
    var page_reload = false;
</script>
@endsection

@section('pagejs')
<script src="{{asset('/js')}}/page/holiday.js"></script>
@endsection