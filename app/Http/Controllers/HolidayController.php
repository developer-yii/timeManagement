<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use App\Models\Student;
use DataTables;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;

class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('subscription.check');
    }

    public function index()
    {
        $student_list = Student::query()
            ->where('user_id',Auth::user()->id)
            ->get()
            ->pluck('first_name','id')
            ->toArray();

        return view('holiday.index',compact('student_list'));
    }
    public function get()
    {
        $data = Holiday::where('student_holidays.user_id',Auth::user()->id)
            ->join('students','students.id','=','student_holidays.student_id')
            ->select('student_holidays.id','start_date','end_date','note','students.first_name','students.last_name','student_holidays.event_color');

        return DataTables::eloquent($data)->toJson();
    }

    public function addupdate(Request $request)
    {
        if($request->ajax()) {
            $rules = array(
                'student_id'=>'required',
                'start_date'=>'required',
                'end_date'=>'required',
                'note'=>'required'
            );
            $msg = '';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
            }else{
                                
                $msg = 'Holiday added successfully';   

                if(is_array($request->student_id))
                {                    
                    foreach($request->student_id as $key => $studentId)
                    {
                        $holiday = new Holiday;
                        $holiday->student_id = $studentId;
                        $holiday->start_date = date('Y-m-d',strtotime($request->start_date));
                        $holiday->end_date = date('Y-m-d',strtotime($request->end_date));
                        $holiday->user_id = Auth::user()->id;
                        $holiday->event_color = $request->event_color;
                        $holiday->note = $request->note;
                        $holiday->created_at = Carbon::now();
                        $holiday->updated_at = Carbon::now();
                        $r = $holiday->save();
                    }
                }
                else{
                    $students = Student::where('user_id',Auth::user()->id)->where('deleted_at',null)->get();
                    $tmp = [];
                    if($students->count())
                    {
                        foreach($students as $key => $stu)
                        {
                            $tmp[$key] = $stu->id;
                        }
                        $request->student_id = $tmp;                        

                        foreach($request->student_id as $key => $studentId)
                        {
                            $holiday = new Holiday;
                            $holiday->student_id = $studentId;
                            $holiday->start_date = date('Y-m-d',strtotime($request->start_date));
                            $holiday->end_date = date('Y-m-d',strtotime($request->end_date));
                            $holiday->user_id = Auth::user()->id;
                            $holiday->event_color = $request->event_color;
                            $holiday->note = $request->note;
                            $holiday->created_at = Carbon::now();
                            $holiday->updated_at = Carbon::now();
                            $r = $holiday->save();
                        }
                    }
                }


                if($r){
                    $result = ['status' => true, 'message' => $msg, 'data' => []];
                }else{
                    $result = ['status' => false, 'message' => 'Error in saving data', 'data' => []];
                }
            }
        }
        else{
            $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
        }
        return response()->json($result);

    }

    public function update(Request $request)
    {
        if($request->ajax()) {
            $rules = array(
                'start_date'=>'required',
                'end_date'=>'required',
                'note'=>'required'
            );
            $msg = '';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
            }else{
                if($request->id)
                {
                    $msg = 'Holiday updated successfully';
                    $model = Holiday::where('user_id',Auth::user()->id)->where('id',$request->id)->first();
                    if($model)
                    {
                        $holiday = $model;
                        $holiday->start_date = date('Y-m-d',strtotime($request->start_date));
                        $holiday->end_date = date('Y-m-d',strtotime($request->end_date));
                        $holiday->user_id = Auth::user()->id;
                        $holiday->event_color = $request->event_color;
                        $holiday->note = $request->note;
                        $holiday->created_at = Carbon::now();
                        $holiday->updated_at = Carbon::now();
                        $r = $holiday->save();
                    }
                    else{
                        $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
                        return response()->json($result);
                    }
                }

                if($r){
                    $result = ['status' => true, 'message' => $msg, 'data' => []];
                }else{
                    $result = ['status' => false, 'message' => 'Error in saving data', 'data' => []];
                }
            }
        }
        else{
            $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
        }
        return response()->json($result);
    }
    
    public function detail(Request $request){
        $c = Holiday::find($request->id);
        if($c->student_id)
        {
            $student = Student::find($c->student_id);
            $c->studentName = $student->first_name;
        }
        
        $result = ['status' => true, 'message' => '', 'data' => $c];
        return response()->json($result);
    }
    
    public function delete(Request $request){

        $user = Holiday::where('id',$request->id)->where('user_id',Auth::user()->id);
        if($user->delete()){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }
}
