<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use Validator;
use DB;
use Carbon\Carbon;
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
    public function index()
    {
        return view('home');
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
