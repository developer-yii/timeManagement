<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogFile;
use App\Models\StudentTimeLog;
use Validator;
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

        $data = DB::table('log_files')           
            ->join('student_time_log','student_time_log.id','log_files.log_id')
            ->join('subjects','student_time_log.subject_id','subjects.id')
            ->join('students','student_time_log.student_id','students.id')
            ->where('student_time_log.user_id',$user_id)
            ->where('student_time_log.deleted_at',null)
            ->where('log_files.deleted_at',null)
            ->orderBy('student_time_log.log_date','desc')
            ->select('log_files.id as file_id','subjects.subject_name','students.first_name','student_time_log.log_date','log_files.file_name');

        // return DataTables::queryBuilder($data)->toJson();

        $tbl = DataTables::queryBuilder($data)
        ->addColumn('files', function($row) {
            
                $fileHtml = '';
               
                $fileExt = pathinfo($row->file_name,PATHINFO_EXTENSION);

                $fileHtml .= '<span class="file">';
                if($fileExt == 'jpg' || $fileExt == 'jpeg' || $fileExt == 'png')
                {

                    $fileHtml .= '<img src="'.url('/storage/uploads/linkFiles\/').$row->file_name.'" height="75" class="ml-10"/>';
                }
                else
                {
                    $fileHtml .= '<a href="'.url('/storage/uploads/linkFiles\/').$row->file_name.'" class="ml-10" download></a>';
                }
                
                $fileHtml .= '</span>';
                    

                return $fileHtml;
            
        })
        ->addColumn('src',function($row){
            $src = url('/storage/uploads/linkFiles\/').$row->file_name;
            return $src;
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

    public function update(Request $request)
    {
        if($request->ajax()) {
            $rules = array(                
                'logo' => 'mimes:pdf,txt,jpg,jpeg,png,xls,xlsx,doc,docx,zip','application/zip|max:5000',
            );
            $message = [
                'logo.mimes' => 'Only pdf,txt,jpg,jpeg,xlsx,docx and png types are allowed,',
                'logo.max' => 'Maximum allowed size for a file is 5MB',
            ];
            $validator = Validator::make($request->all(), $rules, $message);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
                return response()->json($result);
            }else{
                $r = '';
                
                if($request->hasFile('photo'))
                {    
                    $file = $request->file('photo');
                    $fileName = $file->hashName();
                    $path = public_path('storage/uploads/linkFiles');
                    $file->move($path, $fileName);

                    $logfile = LogFile::find($request->id);                    
                    $logfile->file_name = $fileName;
                    $r = $logfile->save();
                }
                if($r){
                    $result = ['status' => true, 'message' => 'file updated successfully', 'data' => []];
                    return response()->json($result);
                }else{
                    $result = ['status' => false, 'message' => 'Error in saving data', 'data' => []];
                    return response()->json($result);
                }
            }
        }
    }
}
