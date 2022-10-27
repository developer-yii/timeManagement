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
        $this->middleware('subscription.check');
    }

    public function index(Request $request)
    {

        $conditionHoliStu = [];
        
        if($request->st)
        {            
            $conditionHoliStu[] = ['student_holidays.student_id','=' ,$request->st];            
        }        

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
            ->select('student_time_log.*','students.*','subjects.*','student_time_log.id as log_id');
            
        if($request->sub)
        {
            $student_subject_log = $student_subject_log->whereIn('subjects.id', $request->sub);
        }
        if($request->st)
        {   
            $student_subject_log = $student_subject_log->where('student_time_log.student_id', $request->st);
        }
        $student_subject_log = $student_subject_log->get();        

        $student_holiday_log = Holiday::query()
            ->join('students','students.id','=','student_holidays.student_id')
            ->where('student_holidays.user_id',$user_id)
            ->where($conditionHoliStu)
            ->select('student_holidays.*','students.*','student_holidays.id as holiday_id')
            ->get();

        $data = array();
        $i=0;
        
        foreach($student_subject_log as $key => $list){
            // $data[$i]['title'] = gmdate("H:i", $list['log_time']*60).' - '.$list['subject_name'].' ('.ucfirst($list['first_name']).' '.substr(ucfirst($list['last_name']),0,1).')';            
            $data[$i]['title'] = $list['log_time'].' - '.$list['subject_name'].' ('.ucfirst($list['first_name']).' '.substr(ucfirst($list['last_name']),0,1).')';
            $data[$i]['start'] = date('Y-m-d',strtotime($list['log_date']));
            $data[$i]['end'] = date('Y-m-d',strtotime($list['log_date']));
            $data[$i]['log_id'] = $list['log_id'];
            // $data[$i]['className'] = 'bg-primary';    
            if(!$list['student_color'])
                $a = '#727cf5';
            else
                $a = $list['student_color'];
            $data[$i]['color'] = $a; 
            $i++;
        }

        foreach($student_holiday_log as $hkey => $hlist){
            $data[$i]['title'] = $hlist['note'].' ('.ucfirst($hlist['first_name']).' '.substr(ucfirst($hlist['last_name']),0,1).')';
            $data[$i]['start'] = date('Y-m-d',strtotime($hlist['start_date']));
            $data[$i]['end'] = date('Y-m-d',strtotime($hlist['end_date'].'+ 1 day')); // 1 day added as fullcalender doesnt count endday
            // $data[$i]['className'] = 'bg-danger';    
            $data[$i]['holiday_id'] = $hlist['holiday_id'];
            if(!$hlist['event_color'])
                $a = '#fa5c7c';
            else
                $a = $hlist['event_color'];
            $data[$i]['color'] = $a;    
            $i++;
        }
        $student = $request->st;
        $subjects = $request->sub; 

        $data_json = json_encode($data);

        return view('studentTimeLog.index',compact('student_list','subject_list','data_json','student','subjects'));
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

        // $month = date("m");
        // $year = date("Y");
        
        // $days = cal_days_in_month(CAL_GREGORIAN,$month,$year);

        // $student_subject_log = StudentTimeLog::query()
        //     ->join('students','students.id','=','student_time_log.student_id')
        //     ->join('subjects','subjects.id','=','student_time_log.subject_id')
        //     ->where('student_time_log.user_id',$user_id)
        //     ->whereYear('log_date', '=', $year)
        //     ->whereMonth('log_date', '=', $month)
        //     ->get();

        // $student_attendances = StudentTimeLog::query()
        //         ->where('student_time_log.user_id',$user_id)
        //         ->where('student_id',$student_subject_log[0]->student_id)
        //         ->whereYear('log_date', '=', $year)
        //         ->whereMonth('log_date', '=', $month)
        //         ->where('is_attendance',1)
        //         ->get();

        // $student_log_data = array();
        // foreach($student_subject_log as $slist){
        //     $student_log_data[$slist['student_id'].'-'.$slist['subject_id'].'-'.date('d',strtotime($slist['log_date']))] = $slist[
        //         'log_time'];
        // }

        // return view('studentTimeLog.monthly_view',compact('subject_list','days','month','year','student_log_data','student_list','student_attendances'));
            return view('studentTimeLog.monthly_view',compact('subject_list','student_list'));
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
                'start_time'=>'required',
                'end_time'=>'required',
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
                $studentTimeLog->start_time = $request->start_time;
                $studentTimeLog->end_time = $request->end_time;
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

    public function create()
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

        return view('studentTimeLog.create',compact('student_list','subject_list'));
    }
    
    public function detail(Request $request){
        $c = StudentTimeLog::find($request->id);
        $result = ['status' => true, 'message' => '', 'data' => $c];
        return response()->json($result);
    }
    
    public function delete(Request $request){

        $model = StudentTimeLog::where('id',$request->id);
        if($model->delete()){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }

    public function logSearch(Request $request)
    {
        $rules = array(
            'student_id' => 'required',
            'year' => 'required',              
            'month' => 'required',            
        );        
        
        $validator = Validator::make($request->all(),$rules);            
        if($validator->fails()){
            $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
        }
        else
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

            $month = $request->month;
            $year = $request->year;
            
            $days = cal_days_in_month(CAL_GREGORIAN,$month,$year);

            $student_subject_log = StudentTimeLog::query()
                ->join('students','students.id','=','student_time_log.student_id')
                ->join('subjects','subjects.id','=','student_time_log.subject_id')
                ->where('student_time_log.user_id',$user_id)
                ->whereYear('log_date', '=', $year)
                ->whereMonth('log_date', '=', $month)
                ->select('student_time_log.id','student_time_log.subject_id','student_time_log.log_date','student_time_log.student_id','student_time_log.log_time')
                ->get();                            

            $student_log_data = array();
            foreach($student_subject_log as $slist){
                $student_log_data[$slist['student_id'].'-'.$slist['subject_id'].'-'.date('d',strtotime($slist['log_date']))] = $slist[
                    'log_time'];

                $student_log_data[$slist['student_id'].'-'.$slist['subject_id'].'-'.date('d',strtotime($slist['log_date'])).'-id'] = $slist[
                    'id'];                
            }            

            $student_attendances = StudentTimeLog::query()
                ->where('student_time_log.user_id',$user_id)
                ->where('student_id',$request->student_id)
                ->whereYear('log_date', '=', $year)
                ->whereMonth('log_date', '=', $month)
                ->where('is_attendance',1)
                ->get();            

            $html = '';

            for($i=1;$i<=$days;$i++){
                $d = sprintf("%02d", $i);
                $logdate = $year.'-'.$month.'-'.$d;
                $attendance = 0;
                
                foreach($student_attendances as $sa)
                {
                    if($sa->log_date == $logdate)
                    {
                        $attendance = 1;
                    }
                } 
                $html.=            
                '<tr>
                    <td>'.$month.'-'.$d.'-'.$year.'</td>
                    <td>'.$attendance.'</td>';
                    foreach($subject_list as $slist)
                    {
                        $s_s_date = $request->student_id.'-'.$slist['id'].'-'.$d;                                
                        $s_s_id = $request->student_id.'-'.$slist['id'].'-'.$d.'-id';                                

                        if(isset($student_log_data[$s_s_date])){
                            $html.='<td><a class="editModal" href="javascript:void(0)" data-id='.$student_log_data[$s_s_id].' data-bs-toggle="modal" data-bs-target="#edit-modal">';                            
                            // $html.= gmdate("H:i", $student_log_data[$s_s_date]*60);
                            $html.= $student_log_data[$s_s_date];
                            $html.='</a><a href="javascript:void(0)" class="delete_log" data-id='.$student_log_data[$s_s_id].'> <i class="dripicons-trash"></i></a></td>';
                        }else{
                            $html.='<td>';
                            $html.= '00:00';
                            $html.='</td>';
                        }
                            
                    }
                $html.='</tr>';
              
            }
            $result = ['status' => true, 'data' => $html];
        }  
        return response()->json($result);      
    }

    public function pdfData(Request $request)
    {
        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
        
        $student = Student::find($request->student_id);
        $month = $months[$request->log_month];
        $year = $request->log_year;

        $result = ['status' => true, 'name' => $student->first_name, 'month' => $month, 'year' => $year];
        return response()->json($result);        
    }
}
