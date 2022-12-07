<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogFile;
use App\Models\StudentTimeLog;
use DataTables;
use Auth;
use DB;

class LogFileController extends Controller
{

    public function index(Request $request)
    {
        return view('files.index');
    }

    public function get(Request $request)
    {
        $user_id = Auth::user()->id;

        $data = DB::table('student_time_log')           
            ->leftjoin('students','student_time_log.student_id','students.id')
            ->leftjoin('subjects','student_time_log.subject_id','subjects.id')
            ->where('student_time_log.user_id',$user_id)
            ->where('student_time_log.deleted_at',null)
            ->orderBy('student_time_log.log_date','desc')
            ->select('student_time_log.id as log_id','subjects.subject_name','students.first_name','student_time_log.log_date');

        $tbl = DataTables::queryBuilder($data)
        ->addColumn('files', function($row) {
            if($row->log_id!="") {    
                $fileHtml = '';
                $c = StudentTimeLog::find($row->log_id);
                $fs = $c->files;
                if($fs)
                {            
                    foreach($fs as $fk => $f)
                    {
                        $fileExt = pathinfo($f->file_name,PATHINFO_EXTENSION);

                        $fileHtml .= '<span class="file">';
                        if($fileExt == 'jpg' || $fileExt == 'jpeg' || $fileExt == 'png')
                        {

                            $fileHtml .= '<img src="'.url('/storage/uploads/linkFiles\/').$f->file_name.'" height="75" />';
                        }
                        else
                        {
                            $fileHtml .= '<a href="'.url('/storage/uploads/linkFiles\/').$f->file_name.'" class="" download></a>';
                        }
                        
                        $fileHtml .= '</span>';
                    }
                }

                return $fileHtml;
            }else{
                return "";
            }
        })
        ->rawColumns(['files'])
        ->toJson();

        return $tbl;        
    }

    public function delete(Request $request)
    {
        $model = LogFile::find($request->id);

        if($model->delete()){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        
        return response()->json($result);
    }
}
