<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentTimeLog;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Holiday;
use DataTables;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;

class StudentTimeLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user_id = Auth::user()->id;

        $student_list = Student::query()
            ->where('user_id',$user_id)
            ->get()
            ->pluck('first_name','id')
            ->toArray();

        $subject_list = Subject::query()
            ->where('user_id',$user_id)
            ->get()
            ->pluck('subject_name','id')
            ->toArray();

        $student_subject_log = StudentTimeLog::query()
            ->join('students','students.id','=','student_time_log.student_id')
            ->join('subjects','subjects.id','=','student_time_log.subject_id')
            ->where('student_time_log.user_id',$user_id)
            ->get();


        $student_holiday_log = Holiday::query()
            ->join('students','students.id','=','student_holidays.student_id')
            ->where('student_holidays.user_id',$user_id)
            ->get();

        $data = array();
        $i=0;
        foreach($student_subject_log as $key => $list){
            $data[$i]['title'] = gmdate("H:i", $list['log_time']*60).' - '.$list['subject_name'].' ('.$list['first_name'].' '.$list['last_name'].')';
            $data[$i]['start'] = date('Y-m-d',strtotime($list['log_date']));
            $data[$i]['end'] = date('Y-m-d',strtotime($list['log_date']));
            $data[$i]['className'] = 'bg-primary';    
            $i++;
        }

        foreach($student_holiday_log as $hkey => $hlist){
            $data[$i]['title'] = $hlist['note'].' ('.$hlist['first_name'].' '.$hlist['last_name'].')';
            $data[$i]['start'] = date('Y-m-d',strtotime($hlist['start_date']));
            $data[$i]['end'] = date('Y-m-d',strtotime($hlist['end_date']));
            $data[$i]['className'] = 'bg-danger';    
            $i++;
        }

        $data_json = json_encode($data);

        return view('studentTimeLog.index',compact('student_list','subject_list','data_json'));
    }
    public function monthlyView()
    {
        $user_id = Auth::user()->id;

        $student_list = Student::query()
            ->where('user_id',$user_id)
            ->get()
            ->pluck('first_name','id')
            ->toArray();

        $subject_list = Subject::query()
            ->where('user_id',$user_id)
            ->get();

        $month = '07';
        $year = '2022';
        
        $days = cal_days_in_month(CAL_GREGORIAN,$month,$year);

        $student_subject_log = StudentTimeLog::query()
            ->join('students','students.id','=','student_time_log.student_id')
            ->join('subjects','subjects.id','=','student_time_log.subject_id')
            ->where('student_time_log.user_id',$user_id)
            ->whereYear('log_date', '=', $year)
            ->whereMonth('log_date', '=', $month)
            ->get();

        $student_log_data = array();
        foreach($student_subject_log as $slist){
            $student_log_data[$slist['student_id'].'-'.$slist['subject_id'].'-'.date('d',strtotime($slist['log_date']))] = $slist[
                'log_time'];
        }

        return view('studentTimeLog.monthly_view',compact('subject_list','days','month','year','student_log_data','student_list'));
    }
    public function get()
    {
        $data = StudentTimeLog::where('user_id',Auth::user()->id);

        return DataTables::eloquent($data)->toJson();
    }

    public function addupdate(Request $request)
    {
        if($request->ajax()) {
            $rules = array(
                'student_id'=>'required',
                'subject_id'=>'required',
                'log_date'=>'required',
                'log_time'=>'required',
            );
            $msg = '';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
            }else{
                if($request->id)
                {
                    $msg = 'Student Time Log updated successfully';
                    $model = StudentTimeLog::where('user_id',Auth::user()->id)->where('id',$request->id)->first();
                    if($model)
                    {
                        $studentTimeLog = $model;
                    }
                    else{
                        $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
                        return response()->json($result);
                    }
                }
                else{
                    $msg = 'Student Time Log added successfully';
                    $studentTimeLog = new StudentTimeLog;
                }

                $studentTimeLog->student_id = $request->student_id;
                $studentTimeLog->log_time = $request->log_time;
                $studentTimeLog->subject_id = $request->subject_id;
                $studentTimeLog->log_date = date('Y-m-d',strtotime($request->log_date));
                $studentTimeLog->user_id = Auth::user()->id;
                $studentTimeLog->is_attendance = 0;    
                if($request->attendance == 'on'){
                    $studentTimeLog->is_attendance = 1;    
                }
                
                $studentTimeLog->activity_notes = $request->activity_notes;
                $studentTimeLog->created_at = Carbon::now();
                $studentTimeLog->updated_at = Carbon::now();

                if($studentTimeLog->save()){
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
        $c = StudentTimeLog::find($request->id);
        $result = ['status' => true, 'message' => '', 'data' => $c];
        return response()->json($result);
    }
    
    public function delete(Request $request){

        $user = StudentTimeLog::where('id',$request->id);
        if($user->delete()){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }
}
