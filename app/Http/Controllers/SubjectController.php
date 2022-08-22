<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use DataTables;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('subject.index');
    }
    public function get()
    {
        $data = Subject::where('user_id',Auth::user()->id);

        return DataTables::eloquent($data)->toJson();
    }

    public function addupdate(Request $request)
    {
        if($request->ajax()) {
            $rules = array(
                'subject_name'=>'required',
                'subject_type'=>'required',
                'subject_color'=>'required',
            );
            $msg = '';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
            }else{
                if($request->id)
                {
                    $msg = 'Subject updated successfully';
                    $model = Subject::where('user_id',Auth::user()->id)->where('id',$request->id)->first();
                    if($model)
                    {
                        $subject = $model;
                    }
                    else{
                        $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
                        return response()->json($result);
                    }
                }
                else{
                    $msg = 'Subject added successfully';
                    $subject = new Subject;
                }

                $subject->subject_name = $request->subject_name;
                $subject->subject_type = $request->subject_type;
                $subject->subject_color = $request->subject_color;
                $subject->user_id = Auth::user()->id;
                $subject->created_at = Carbon::now();
                $subject->updated_at = Carbon::now();

                if($subject->save()){
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
        $c = Subject::find($request->id);
        $result = ['status' => true, 'message' => '', 'data' => $c];
        return response()->json($result);
    }
    
    public function delete(Request $request){

        $user = Subject::where('id',$request->id)->where('user_id',Auth::user()->id);
        if($user->delete()){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }
}
