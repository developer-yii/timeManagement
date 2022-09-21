<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Holiday;
use App\Models\StudentTimeLog;
use DataTables;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('subscription.check');
    }

    public function index()
    {
        $gradeLevels = Student::$gradeLevel;
        return view('student.index',compact('gradeLevels'));
    }
    public function get()
    {
        $gradeLevel = Student::$gradeLevel;

        $data = Student::where('user_id',Auth::user()->id);

        return DataTables::eloquent($data)
                ->addColumn('grade_name', function($row) use ($gradeLevel) {
                    return isset($gradeLevel[$row->grade_level]) ? $gradeLevel[$row->grade_level]:"";
                })
                ->toJson();
    }

    public function addupdate(Request $request)
    {
        if($request->ajax()) {
            $rules = array(
                'first_name'=>'required',
                // 'last_name'=>'required',
                'student_color'=>'required',
                'attendance'=>'required',
                'hours'=>'required',
                'email'=>'nullable|email',
            );
            $msg = '';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
            }else{
                if($request->id)
                {
                    $msg = 'Student updated successfully';
                    $model = Student::where('user_id',Auth::user()->id)->where('id',$request->id)->first();
                    if($model)
                    {
                        $student = $model;
                    }
                    else{
                        $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
                        return response()->json($result);
                    }
                }
                else{
                    $msg = 'Student added successfully';
                    $student = new Student;
                }

                $student->first_name = $request->first_name;
                $student->last_name = $request->last_name;
                $student->email = $request->email;
                $student->phone = $request->phone;
                $student->student_color = $request->student_color;
                $student->grade_level = $request->grade_level;
                $student->hours_required = $request->hours;
                $student->attendance_required = $request->attendance;
                $student->user_id = Auth::user()->id;
                $student->created_at = Carbon::now();
                $student->updated_at = Carbon::now();

                if($student->save()){
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
        $c = Student::find($request->id);
        $result = ['status' => true, 'message' => '', 'data' => $c];
        return response()->json($result);
    }
    
    public function delete(Request $request){

        $model = Student::where('id',$request->id)->where('user_id',Auth::user()->id);

        $c = Holiday::where('student_id',$request->id)->delete();

        $d = StudentTimeLog::where('student_id',$request->id)->delete();

        if($model->delete() && $c && $d){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }
}
