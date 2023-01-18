<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocode;
use App\User;
use DataTables;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;

class PromoCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('admin.user');
    }

    public function index()
    {       
        return view('promocodes.index');         
    }

    public function get()
    {
        $data = Promocode::query();

        return DataTables::eloquent($data)->toJson();
    }

    public function addupdate(Request $request)
    {
        if($request->ajax()) {
            $rules = array(
                'promocode'=>'required|unique:promocodes,promocode|size:21|regex:/^[a-zA-Z0-9-]{5}[a-zA-Z0-9{5}-]{6}[a-zA-Z0-9{4}-]{5}[a-zA-Z0-9-]{5}$/',                
            );
            $msg = '';
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                $result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
                return response()->json($result);
            }else{
                if($request->id)
                {
                    $msg = 'Promo code updated successfully';
                    $model = Promocode::find($request->id);
                    if($model)
                    {
                        $promocode = $model;
                    }
                    else{
                        $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
                        return response()->json($result);
                    }
                }
                else{
                    $msg = 'Promo code added successfully';
                    $promocode = new Promocode;
                }

                $promocode->promocode = $request->promocode;
                $promocode->created_by = Auth::user()->id;

                if($promocode->save()){
                    $result = ['status' => true, 'message' => $msg, 'data' => []];
                    return response()->json($result);
                }else{
                    $result = ['status' => false, 'message' => 'Error in saving data', 'data' => []];
                    return response()->json($result);
                }
            }
        }
        else{
            $result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
        }
        return response()->json($result);

    }

    public function detail(Request $request){
        $c = Promocode::find($request->id);
        $result = ['status' => true, 'message' => '', 'data' => $c];
        return response()->json($result);
    }

    public function delete(Request $request){

        $model = Promocode::find($request->id);

        $d = User::where('promocode_id',$request->id)->first();
        if($d)
        {            
            $d->promocode_id = null;
            $d->save();
        }

        if($model->delete()){
            $result = ['status' => true, 'message' => 'Delete successfully'];
        }else{
            $result = ['status' => false, 'message' => 'Delete fail'];
        }
        return response()->json($result);
    }

    public function generate(Request $request)
    {
        if($request->ajax()) {
            return generateUniquePromoCode();
        }        
    }
}
