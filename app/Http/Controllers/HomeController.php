<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use Validator;
use DB;
use App\User;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentTimeLog;
use App\Models\StudentDateRange;
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
        $this->middleware('subscription.check')->only(['index','profile','password']);;
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
        $hours_required = 0;
        $attendance_required = 0;
        
        if($studentObj)
        {            
            $attendance_required = $studentObj->attendance_required;
            $hours_required = $studentObj->hours_required;
        }        
            
        $tempDateArray = '';

        if(isset($request->daterange))
        {            
            $dtArray = explode('-',$request->daterange);
            $firstDay = date('Y-m-d', strtotime($dtArray[0]));
            $lastDay = date('Y-m-d', strtotime($dtArray[1]));

            $studentDaterange = StudentDateRange::where('student_id',$s)->first();
            if($studentDaterange)
            {   
                $tempDateArray = $studentDaterange->daterange = $request->daterange;             
            }
            else
            {
                $studentDaterange = new StudentDateRange;
                $tempDateArray = $studentDaterange->daterange = $request->daterange;
                $studentDaterange->student_id = $s;
            }
            $studentDaterange->save();
        }
        else
        {   
            $studentDaterange = StudentDateRange::where('student_id',$s)->first();
            if($studentDaterange)
            {                
                $dtArray = explode('-',$studentDaterange->daterange);
                $firstDay = date('Y-m-d', strtotime($dtArray[0]));
                $lastDay = date('Y-m-d', strtotime($dtArray[1]));
                $tempDateArray = $studentDaterange->daterange;
            }
            else
            {
                // $y = date('Y');                
                // $firstDay = $y.'-01-01';
                // $lastDay = $y.'-12-31';

                // $firstDay = date('m/d/Y', strtotime($firstDay));
                // $lastDay = date('m/d/Y', strtotime($lastDay));
                $y = date('Y');
                $date = Carbon::createFromDate($y, 2, 23);

                $firstDay = $date->copy()->startOfYear()->format('Y/m/d');
                $lastDay   = $date->copy()->endOfYear()->format('Y/m/d');

                $tempDateArray = $firstDay.' - '.$lastDay;       
                // echo $tempDateArray;die;         
            }
        }

         

        $coreSubjects = DB::table('subjects')
                    ->leftJoin('student_time_log', function($join) use ($user_id,$s,$firstDay,$lastDay) {
                          $join->on('subjects.id', '=', 'student_time_log.subject_id')
                            ->where('student_time_log.student_id',$s)
                            ->where('student_time_log.log_date','>',$firstDay)
                            ->where('student_time_log.log_date','<',$lastDay);
                        })
                    ->where('student_time_log.deleted_at',null)
                    ->where('subjects.user_id',$user_id)                    
                    ->where('subjects.subject_type',1)
                    ->where('subjects.deleted_at',null)
                    ->select('subjects.subject_name',DB::raw('SUM( COALESCE(TIME_TO_SEC( student_time_log.log_time),0 )) as time'))
                    ->groupBy('subjects.subject_name')
                    ->get();
        
        $max_core_array = [];
        foreach($coreSubjects as $key => $core)
        {
            $max_core_array[$key] = $core->time;
        }

        $maxCore = 0;

        if(count($max_core_array))
        {
            $maxCore = max($max_core_array);
        }

        $nonCoreSubjects = DB::table('subjects')
                    ->leftJoin('student_time_log', function($join) use ($user_id,$s,$firstDay,$lastDay) {
                          $join->on('subjects.id', '=', 'student_time_log.subject_id')
                            ->where('student_time_log.student_id',$s)
                            ->where('student_time_log.log_date','>',$firstDay)
                            ->where('student_time_log.log_date','<',$lastDay);
                        })
                    ->where('student_time_log.deleted_at',null)
                    ->where('subjects.user_id',$user_id)                    
                    ->where('subjects.subject_type',2)  
                    ->where('subjects.deleted_at',null)                  
                    ->select('subjects.subject_name',DB::raw('SUM( COALESCE(TIME_TO_SEC( student_time_log.log_time),0 )) as time'))
                    ->groupBy('subjects.subject_name')
                    ->get();          

        $max_noncore_array = [];
        foreach($nonCoreSubjects as $key => $nonCore)
        {
            $max_noncore_array[$key] = $nonCore->time;
        }

        $maxNonCore = 0;
        if(count($max_noncore_array))
        {            
            $maxNonCore = max($max_noncore_array);           
        }

        // core NonCore Hours by month : Starts
        $coreMonths = DB::table('student_time_log')
            ->join('subjects','student_time_log.subject_id','subjects.id')
            ->where('student_time_log.deleted_at',null)
            ->where('student_time_log.user_id',$user_id)
            ->where('student_time_log.student_id',$s)
            ->where('subjects.subject_type',1)
            ->where('student_time_log.log_date','>',$firstDay)
            ->where('student_time_log.log_date','<',$lastDay)
            ->select('student_time_log.id','student_time_log.log_date','student_time_log.log_time')
            ->get();

        $coreMonthArray = [];        

        for($b = 1; $b < 13; $b++)
        {
            if($b<10)
                $m = '0'.$b;
            else
                $m = $b;

            $coreMonthArray[$m] = 0;
        }

        foreach($coreMonths as $coreM)
        {
            $pieces = explode("-", $coreM->log_date);            
            $coreMonthArray[$pieces[1]] = $coreMonthArray[$pieces[1]] + hhmmToSec($coreM->log_time);            
        }

        foreach($coreMonthArray as $key => $cm)
        {            
            $coreMonthArray[$key] = sectoHH($cm);
        }

        $coreMonthArray = array_values($coreMonthArray);        

        $coreMonthArray = json_encode($coreMonthArray);

        // NonCore
        $nonCoreMonths = DB::table('student_time_log')
            ->join('subjects','student_time_log.subject_id','subjects.id')
            ->where('student_time_log.deleted_at',null)
            ->where('student_time_log.user_id',$user_id)
            ->where('student_time_log.student_id',$s)
            ->where('subjects.subject_type',2)
            ->where('student_time_log.log_date','>',$firstDay)
            ->where('student_time_log.log_date','<',$lastDay)
            ->select('student_time_log.id','student_time_log.log_date','student_time_log.log_time')
            ->get();

        $nonCoreMonthArray = [];        

        for($b1 = 1; $b1 < 13; $b1++)
        {
            if($b1<10)
                $m1 = '0'.$b1;
            else
                $m1 = $b1;

            $nonCoreMonthArray[$m1] = 0;
        }

        foreach($nonCoreMonths as $nonCoreM)
        {
            $pieces1 = explode("-", $nonCoreM->log_date);            
            $nonCoreMonthArray[$pieces1[1]] = $nonCoreMonthArray[$pieces1[1]] + hhmmToSec($nonCoreM->log_time);            
        }

        foreach($nonCoreMonthArray as $key => $ncm)
        {            
            $nonCoreMonthArray[$key] = sectoHH($ncm);
        }

        $nonCoreMonthArray = array_values($nonCoreMonthArray);
        $nonCoreMonthArray = json_encode($nonCoreMonthArray);
        // core NonCore Hours by month : Ends


        $coreHoursinSec = DB::table('student_time_log')
            ->join('subjects','student_time_log.subject_id','subjects.id')
            ->where('student_time_log.deleted_at',null)
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
            ->where('student_time_log.deleted_at',null)
            ->where('student_time_log.user_id',$user_id)
            ->where('student_time_log.student_id',$s)
            ->where('subjects.subject_type',2)
            ->where('student_time_log.log_date','>',$firstDay)
            ->where('student_time_log.log_date','<',$lastDay)
            ->sum(DB::raw('( TIME_TO_SEC( student_time_log.log_time) )'));

        $nonCoreHours = secToHHmm($nonCoreHoursinSec);

        $nonCoreHoursHH = convertToHH($nonCoreHours);

        $totalHoursRequired = (int) $hours_required;
        
        $hoursCompleted = secToHHmm4($coreHoursinSec + $nonCoreHoursinSec);
        $hoursCompletedA = secToHHmm($coreHoursinSec + $nonCoreHoursinSec);
        $hoursCompletedHH = convertToHH($hoursCompletedA);

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
              ->where('student_time_log.deleted_at',null)
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
        if($stillReq < 0) // if attendance required is 0
            $attendanceArray[1] = 0;
        else
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
        

        return view('home',compact('students','coreSubjects','nonCoreSubjects','coreHours','nonCoreHours','hoursCompleted','attendance','s','tempDateArray','maxCore','maxNonCore','attendanceArray','hoursHHArray','attendance_required','hours_required','hoursHHBarArray','hourCoreNonCoreArray','coreSubjectsColumn','coreSubjectsTimeColumn','nonCoreSubjectsColumn','nonCoreSubjectsTimeColumn','coreMonthArray','nonCoreMonthArray'));
    }



    public function profile()
    {
        $user = Auth::user();
        return view('profile.index',compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());die;

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

                    if ($request->hasFile('profilephoto')) {                        

                        if($user->profilephoto != '') {
                            if(file_exists(public_path('storage/uploads/profile') . $user->profilephoto)) {
                                unlink(public_path('storage/uploads/profile') . $user->profilephoto);
                            }
                        }          
                        
                        $fileName = $request->file('profilephoto')->hashName();
                        $path = public_path('storage/uploads/profile');
                        request()->profilephoto->move($path, $fileName);

                        $user->profilephoto = $fileName;
                    }

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

    public function getReferral(Request $request)
    {
        if($request->ajax()) 
        {
            $user = Auth::user();
            $data = User::where('referral_id',$user->referral_code)
                   ->select('name','email')
                   ->get();            

            return DataTables::of($data)                
                ->toJson();
        }
    }

    public function getDateRange(Request $request)
    {
        if($request->id)
        {
            $dateRange = StudentDateRange::where('student_id',$request->id)->first();
            if($dateRange)
            {
                $result = ['status' => true, 'message' => '', 'dateRange' => $dateRange->daterange];
                return response()->json($result);
            }
        }        
    }
}
