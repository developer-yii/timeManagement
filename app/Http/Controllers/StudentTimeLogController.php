<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentTimeLog;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Holiday;
use App\Models\Link;
use App\Models\LogFile;
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
        $gradeLevels = Student::$gradeLevel;

        $links = Link::where('user_id',Auth::user()->id)->where('deleted_at',null)->get();        

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
            ->leftjoin('students','students.id','=','student_holidays.student_id')
            ->where('student_holidays.user_id',$user_id)
            ->where($conditionHoliStu)
            ->select('student_holidays.*','students.*','student_holidays.id as holiday_id')
            ->get();

        $data = array();
        $i=0;
        
        foreach($student_subject_log as $key => $list){
            // $data[$i]['title'] = gmdate("H:i", $list['log_time']*60).' - '.$list['subject_name'].' ('.ucfirst($list['first_name']).' '.substr(ucfirst($list['last_name']),0,1).')';     
            if($list->is_completed)
            {
                $data[$i]['title'] = '&'.$list['log_time'].' - '.$list['subject_name'].' ('.ucfirst($list['first_name']).' '.substr(ucfirst($list['last_name']),0,1).')';
            }
            else
            {
                $data[$i]['title'] = $list['log_time'].' - '.$list['subject_name'].' ('.ucfirst($list['first_name']).' '.substr(ucfirst($list['last_name']),0,1).')';
            }       
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
            if($hlist['student_id'] == 0)
            {
                $data[$i]['title'] = $hlist['note'].' (All)';
            }
            else
            {
                $data[$i]['title'] = $hlist['note'].' ('.ucfirst($hlist['first_name']).' '.substr(ucfirst($hlist['last_name']),0,1).')';
            }
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

        return view('studentTimeLog.index',compact('student_list','links','subject_list','data_json','student','subjects','gradeLevels'));
    }
    public function monthlyView()
    {
        $user_id = Auth::user()->id;

        $links = Link::where('user_id',Auth::user()->id)->where('deleted_at',null)->get();

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
            return view('studentTimeLog.monthly_view',compact('subject_list','student_list','links'));
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
                'hrs' => 'required|numeric|gte:0|max:23',
                'minutes'=> 'required|integer|gte:0|max:59',
                // 'log_time'=>'required',
                // 'start_time'=>'required',
                // 'end_time'=>'required',
                'formFileMultiple.*' => 'mimes:pdf,txt,jpg,jpeg,png,xls,xlsx,doc,docx,zip','application/zip|max:5000',
            );
            $message = [
                'formFileMultiple.*.mimes' => 'Only pdf,txt,jpg,jpeg,xlsx,docx and png types are allowed,',
                'formFileMultiple.*.max' => 'Maximum allowed size for a file is 5MB',
            ];
            $validator = Validator::make($request->all(), $rules, $message);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
                return response()->json($result);
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
                // $studentTimeLog->start_time = $request->start_time;
                // $studentTimeLog->end_time = $request->end_time;
                $studentTimeLog->log_time = $request->hrs.':'.sprintf("%02d", $request->minutes);
                $studentTimeLog->subject_id = $request->subject_id;
                $studentTimeLog->log_date = date('Y-m-d',strtotime($request->log_date));
                $studentTimeLog->user_id = Auth::user()->id;
                $studentTimeLog->is_attendance = 0;    
                if($request->attendance == 'on'){
                    $studentTimeLog->is_attendance = 1;    
                }

                $studentTimeLog->is_completed = 0;    
                if($request->completed == 'on'){
                    $studentTimeLog->is_completed = 1;    
                }
                
                $studentTimeLog->activity_notes = $request->activity_notes;
                $studentTimeLog->created_at = Carbon::now();
                $studentTimeLog->updated_at = Carbon::now();
                $r = $studentTimeLog->save();

                if(isset($request->links))
                {
                    $addresses = $request->address;
                    // $links_array = array_unique($request->links);
                    // $links = implode(', ', $links_array);
                    // $studentTimeLog->links = $links;
                    foreach ($request->links as $klink => $link) {
                        if($link && $addresses[$klink])
                        {                            
                            $linkObj = new Link;
                            $linkObj->name = $link;
                            $linkObj->link = $addresses[$klink];
                            $linkObj->log_id = $studentTimeLog->id;
                            $linkObj->user_id = Auth::user()->id;
                            $linkObj->save();
                        }
                    }
                }
                
                if($request->hasFile('formFileMultiple'))
                {
                    foreach ($request->file('formFileMultiple') as $file) 
                    {
                        $fileName = $file->hashName();
                        $path = public_path('storage/uploads/linkFiles');
                        $file->move($path, $fileName);

                        $logfile = new LogFile;
                        $logfile->log_id = $studentTimeLog->id;
                        $logfile->file_name = $fileName;
                        $logfile->save();
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

    public function create()
    {
        $user_id = Auth::user()->id;

        $links = Link::where('user_id',Auth::user()->id)->where('deleted_at',null)->get();

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

        return view('studentTimeLog.create',compact('student_list','subject_list','links'));
    }
    
    public function detail(Request $request){
        $c = StudentTimeLog::find($request->id);
        
        $a = explode(':', $c->log_time);
        $hrs = $a[0];
        $minutes = $a[1];

        $fs = $c->files;
        $paths = [];
        $fileHtml = '';

        if($fs)
        {            
            foreach($fs as $fk => $f)
            {
                $fileExt = pathinfo($f->file_name,PATHINFO_EXTENSION);

                $fileHtml .= '<span class="file">';
                if($fileExt == 'jpg' || $fileExt == 'jpeg' || $fileExt == 'png')
                {

                    $fileHtml .= '<a href="'.url('/storage/uploads/linkFiles\/').$f->file_name.'" class="" download><img src="'.url('/storage/uploads/linkFiles\/').$f->file_name.'" height="25" /></a>';
                }
                else
                {
                    $fileHtml .= '<a href="'.url('/storage/uploads/linkFiles\/').$f->file_name.'" class="" download></a>';
                }

                $fileHtml .= '<a class="delete-u-file" data-id="'.$f->id.'" href="#"><img src="'.asset("images/file-icons/circle_remove.png").'"/></a>';
                $fileHtml .= '</span>';
            }
        }

        $links = Link::where('user_id',Auth::user()->id)->where('log_id',$request->id)->where('deleted_at',null)->get();
        $html = '';
        
        foreach($links as $k => $loglink)
        {                
            $html .= '<div class="mb-1">
                    <div class="row linkrow">';
                        $temp = '';
                        $html .='<div class="col-sm-5">';                            
                            // <select name="links[]" id="links" class="form-control links">';
                                // foreach($links as $key => $link)
                                // {
                                    // if($loglink->id == $link->id)
                                    // {
                                        $html .= '<p>'.$loglink->name.'</p>';
                                        // $temp = $link->link;
                                        // $html .= '<option value="'.$link->id.'" selected>'.$link->name.'</option>';
                                    // }
                                    // else
                                    // {
                                    //     $html .= '<option value="'.$link->id.'">'.$link->name.'</option>';   
                                    // }
                                // }
                            // $html .='</select>';
                        $html .='</div>';
                        $html .= '<div class="col-sm-5">';
                            // $html .='<input type="text" class="form-control" name="address[]" value="'. $temp .'" readonly>';
                        $html .= '<p><a href="'.$loglink->link.'" target="_blank">'.$loglink->link.'</a></p>';
                        $html .= '</div>
                        <div class="col-sm-2">
                            <button class="btn btn-danger deleteRow"
                                data-id="'.$loglink->id.'" type="button">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                        $html .='</div>
                    </div>
                    <span class="error"></span>
                </div>';
        }
 
        
        $result = ['status' => true, 'message' => '', 'data' => $c, 'html' => $html, 'fileHtml' => $fileHtml,'hrs' => $hrs, 'minutes' => $minutes];
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
                ->where('student_time_log.deleted_at',null)
                ->where('student_time_log.student_id',$request->student_id)
                ->whereYear('log_date', '=', $year)
                ->whereMonth('log_date', '=', $month)
                ->select('student_time_log.id','student_time_log.subject_id','student_time_log.log_date','student_time_log.student_id','student_time_log.log_time')
                ->get();        

            // For total hours monthwise per subject          
            $sub_array = [];
            
            foreach($student_subject_log as $slist){
                $id = $slist['subject_id'];
                $sub_array[$id][] = hhmmToSec($slist['log_time']);
            }
            foreach($sub_array as $k => $v)
            {
                $new[$k] = secToHHmm(array_sum($v)); 
            }            
            // For total hours monthwise per subject  : Ends

            $student_log_data = array();
            foreach($student_subject_log as $slist){
                $student_log_data[$slist['student_id'].'-'.$slist['subject_id'].'-'.date('d',strtotime($slist['log_date']))] = $slist[
                    'log_time'];

                $student_log_data[$slist['student_id'].'-'.$slist['subject_id'].'-'.date('d',strtotime($slist['log_date'])).'-id'] = $slist[
                    'id'];                
            }            

            $student_attendances = StudentTimeLog::query()
                ->where('student_time_log.deleted_at',null)
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
            $html.=            
                '<tr>
                    <td colspan="2" class="font-bold"> Total</td>';
                    
                    foreach($subject_list as $slist)
                    {
                        if(isset($new[$slist['id']]))
                            $html.='<td class="font-bold">'.$new[$slist['id']].'</td>';
                        else
                            $html.='<td class="font-bold">00:00</td>';
                    }
                    $html.='</tr>';
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
