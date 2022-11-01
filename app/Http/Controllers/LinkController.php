<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use DataTables;
use Auth;
use DB;
use Carbon\Carbon;
use Validator;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('subscription.check');
    }

    public function index()
    {
        return view('links.index');
    }

    public function get()
    {
        $data = Link::where('user_id',Auth::user()->id);

        return DataTables::eloquent($data)->toJson();
    }

    public function addupdate(Request $request)
    {
        if($request->ajax()) {
            $rules = array(
                'name'=>'required',
                'link'=>'required',                
            );
            $msg = '';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
            }else{
                if($request->id)
                {
                    $msg = 'Link updated successfully';
                    $model = Link::where('user_id',Auth::user()->id)->where('id',$request->id)->first();
                    if($model)
                    {
                        $link = $model;
                    }
                    else{
                        $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
                        return response()->json($result);
                    }
                }
                else{
                    $msg = 'Link added successfully';
                    $link = new Link;
                }

                $link->name = $request->name;
                $link->link = $request->link;                
                $link->user_id = Auth::user()->id;
                

                if($link->save()){
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
        $c = Link::find($request->id);
        $result = ['status' => true, 'message' => '', 'data' => $c];
        return response()->json($result);
    }
    
    public function delete(Request $request){

        $model = Link::where('id',$request->id)->where('user_id',Auth::user()->id);        

        if($model->delete()){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }

    public function getlink(Request $request)
    {
        if($request->id)
        {
            $model = Link::find($request->id);
            $result = ['status' => true, 'message' => 'success','link' => $model->link];
            return response()->json($result);
        }
        
        $result = ['status' => true, 'message' => 'failed','link' => ''];
        return response()->json($result);
    }
}
