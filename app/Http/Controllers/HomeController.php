<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use Validator;
use DB;
use App\helpers;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentTimeLog;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;

        $students = Student::query()
            ->where('user_id',$user_id)
            ->pluck('first_name','id');                    
            
        $s = 0;
        if(isset($request->s))
        {            
            $s = $request->s;
        }
        else
        {    
            if($students)
            {                
                foreach ($students as $key => $value) {
                    $s = $key;
                    break;
                }
            }
        }

        $studentObj = Student::find($s);
        $attendance_required = $studentObj->attendance_required;
        $hours_required = $studentObj->hours_required;


        $y = date('Y');
        if(isset($request->y))
        {            
            $y = $request->y;
        }        

        $firstDay = $y.'-01-01';
        $lastDay = $y.'-12-31';

        $coreSubjects = DB::table('subjects')
                    ->leftJoin('student_time_log', function($join) use ($user_id,$s,$firstDay,$lastDay) {
                          $join->on('subjects.id', '=', 'student_time_log.subject_id')
                            ->where('student_time_log.student_id',$s)
                            ->where('student_time_log.log_date','>',$firstDay)
                            ->where('student_time_log.log_date','<',$lastDay);
                        })
                    ->where('subjects.user_id',$user_id)                    
                    ->where('subjects.subject_type',1)                    
                    ->select('subjects.subject_name',DB::raw('SUM( COALESCE(TIME_TO_SEC( student_time_log.log_time),0 )) as time'))
                    ->groupBy('subjects.subject_name')
                    ->get();
        
        $max_core_array = [];
        foreach($coreSubjects as $key => $core)
        {
            $max_core_array[$key] = $core->time;
        }

        $maxCore = max($max_core_array);

        $nonCoreSubjects = DB::table('subjects')
                    ->leftJoin('student_time_log', function($join) use ($user_id,$s,$firstDay,$lastDay) {
                          $join->on('subjects.id', '=', 'student_time_log.subject_id')
                            ->where('student_time_log.student_id',$s)
                            ->where('student_time_log.log_date','>',$firstDay)
                            ->where('student_time_log.log_date','<',$lastDay);
                        })
                    ->where('subjects.user_id',$user_id)                    
                    ->where('subjects.subject_type',2)                    
                    ->select('subjects.subject_name',DB::raw('SUM( COALESCE(TIME_TO_SEC( student_time_log.log_time),0 )) as time'))
                    ->groupBy('subjects.subject_name')
                    ->get();          

        $max_noncore_array = [];
        foreach($nonCoreSubjects as $key => $nonCore)
        {
            $max_noncore_array[$key] = $nonCore->time;
        }

        $maxNonCore = max($max_noncore_array);           

        $coreHoursinSec = DB::table('student_time_log')
            ->join('subjects','student_time_log.subject_id','subjects.id')
            ->where('student_time_log.user_id',$user_id)
            ->where('student_time_log.student_id',$s)
            ->where('subjects.subject_type',1)
            ->where('student_time_log.log_date','>',$firstDay)
            ->where('student_time_log.log_date','<',$lastDay)
            ->sum(DB::raw('( TIME_TO_SEC( student_time_log.log_time) )'));                       

        $coreHours = secToHHmm($coreHoursinSec);

        $coreHoursHH = convertToHH($coreHours);

        $nonCoreHoursinSec = DB::table('student_time_log')
            ->join('subjects','student_time_log.subject_id','subjects.id')
            ->where('student_time_log.user_id',$user_id)
            ->where('student_time_log.student_id',$s)
            ->where('subjects.subject_type',2)
            ->where('student_time_log.log_date','>',$firstDay)
            ->where('student_time_log.log_date','<',$lastDay)
            ->sum(DB::raw('( TIME_TO_SEC( student_time_log.log_time) )'));

        $nonCoreHours = secToHHmm($nonCoreHoursinSec);

        $nonCoreHoursHH = convertToHH($nonCoreHours);

        $totalHoursRequired = (int) $hours_required;
        
        $hoursCompleted = secToHHmm($coreHoursinSec + $nonCoreHoursinSec);
        $hoursCompletedHH = convertToHH($hoursCompleted);

        $hoursRequiredHH = $totalHoursRequired - $hoursCompletedHH;

        $hoursHHArray = [];
        $hoursHHArray[0] = $coreHoursHH;
        $hoursHHArray[1] = $nonCoreHoursHH;
        $hoursHHArray[2] = $hoursCompletedHH;
        $hoursHHArray[3] = $totalHoursRequired;

        $hoursHHBarArray = [];
        $hoursHHBarArray[0] = $totalHoursRequired;
        $hoursHHBarArray[1] = $hoursCompletedHH;

        $hourCoreNonCoreArray = [];
        $hourCoreNonCoreArray[0] = $coreHoursHH;
        $hourCoreNonCoreArray[1] = $nonCoreHoursHH;

        $hoursHHArray = json_encode($hoursHHArray);
        $hoursHHBarArray = json_encode($hoursHHBarArray);
        $hourCoreNonCoreArray = json_encode($hourCoreNonCoreArray);   
        
        $attendance = DB::table('student_time_log')
              ->where('user_id',$user_id)
              ->where('student_id',$s) 
              ->where('log_date','>',$firstDay)
              ->where('log_date','<',$lastDay)             
              ->groupBy('log_date')
              ->get()
              ->sum('is_attendance');
        
        $attendanceArray = [];
        $stillReq = $attendance_required - $attendance;
        
        $attendanceArray[0] = $attendance;
        $attendanceArray[1] = $stillReq;
        
        
        $attendanceArray = json_encode($attendanceArray);        

        $nonCoreSubjectsColumn = [];
        $nonCoreSubjectsTimeColumn = [];
        foreach($nonCoreSubjects as $key => $ncs)
        {
            $nonCoreSubjectsColumn[$key] = (string) $ncs->subject_name;
            $nonCoreSubjectsTimeColumn[$key] = sectoHH($ncs->time);            
        }

        $nonCoreSubjectsColumn = json_encode($nonCoreSubjectsColumn);
        $nonCoreSubjectsTimeColumn = json_encode($nonCoreSubjectsTimeColumn);

        $coreSubjectsColumn = [];
        $coreSubjectsTimeColumn = [];
        foreach($coreSubjects as $key => $ncs1)
        {
            $coreSubjectsColumn[$key] = (string) $ncs1->subject_name;
            $coreSubjectsTimeColumn[$key] = sectoHH($ncs1->time);            
        }
        $coreSubjectsColumn = json_encode($coreSubjectsColumn);
        $coreSubjectsTimeColumn = json_encode($coreSubjectsTimeColumn);
        

        return view('home',compact('students','coreSubjects','nonCoreSubjects','coreHours','nonCoreHours','hoursCompleted','attendance','s','y','maxCore','maxNonCore','attendanceArray','hoursHHArray','attendance_required','hours_required','hoursHHBarArray','hourCoreNonCoreArray','coreSubjectsColumn','coreSubjectsTimeColumn','nonCoreSubjectsColumn','nonCoreSubjectsTimeColumn'));
    }



    public function profile()
    {
        $user = Auth::user();
        return view('profile.index',compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if($request->ajax()) {
            $rules = array(
                'name'=>'required',
                'email'=>'required|email',                
            );
            $msg = 'Profile saved successfully';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
            }else{

                $user = Auth::user();
                if($user)
                {
                    $user->name = $request->name;
                    $user->email = $request->email;

                    if($user->save()){
                        $result = ['status' => true, 'message' => $msg, 'data' => []];
                    }else{
                        $result = ['status' => false, 'message' => 'Error in saving data', 'data' => []];
                    }
                }
                else{
                    $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
                    return response()->json($result);
                }               

            }
        }
        else{
            $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
        }
        return response()->json($result);
    }

    public function password()
    {
        return view('profile.password');
    }

    public function passwordUpdate(Request $request)
    {
        if($request->ajax()) {

            $rules = array(
                'old_password' => 'required',
                'password' => 'confirmed|required|min:8|string|different:old_password'               
            );
            $msg = 'Profile saved successfully';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
            }else{

                if (!(Hash::check($request->old_password, Auth::user()->password))) {
                return response()->json(['status' => false, 'message' => ['old_password' => ['Your current password does not matches with the password.']],'data' => []] );
                }

                if (strcmp($request->old_password, $request->password) == 0) {
                    return response()->json(['status' => false, 'message' => ['password' => ['New Password cannot be same as your current password.']],'data' => []] );
                }

                $user = Auth::user();
                $user->password = bcrypt($request->password);
                $user->save();

                return response()->json(['status' => true, 'message' => 'Password changed successfully!', 'data' => $user], 200);

            }
        }
        else{
            $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
        }
        return response()->json($result);
    }
}
