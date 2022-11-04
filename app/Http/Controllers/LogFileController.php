<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogFile;

class LogFileController extends Controller
{
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
