<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Holiday;
use App\Models\StudentTimeLog;
use DataTables;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('admin.user');
    }

    public function index()
    {
        // $gradeLevels = User::$gradeLevel;
        return view('users.index');
    }

    public function get()
    {
        $data = User::query()
            ->select('id','name','email','user_type');
            

        return DataTables::eloquent($data)
                ->addColumn('type', function($row) {
                    if($row->user_type == 1)
                        return 'Admin';
                    elseif($row->user_type == 2)
                        return 'Parent';
                    elseif($row->user_type == 3)
                        return 'Teacher';
                    elseif($row->user_type == 4)
                        return 'Affiliate/Business';
                })
                ->toJson();
    }

    public function login(Request $request)
    {
        if($request->id)
        {
            $auth_check = Auth::loginUsingId($request->id);

            $result = ['status' => true, 'message' => 'login success', 'data' => []];
            return response()->json($result);
        }
        else 
        {
            $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
            return response()->json($result);
        }
    }

    public function delete(Request $request){

        $t = time();       

        $user = User::find($request->id);        
        $user->email = $user->email.'_'.$t;
        $r = $user->save();        
        $user->delete();

        if($r){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }
}
