<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 180);

use Illuminate\Http\Request;
use App\User;
use Validator;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\IdCard;
use File;
use DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
// use Image;
use Intervention\Image\Facades\Image;

class IdCardController extends Controller
{
	public function index()
    {
        return view('id_card.index');
    }

	public function get()
    {
        $data = IdCard::where('status', 1);

        return DataTables::eloquent($data)
        	->editColumn('card_type', function($row) {
        		return ($row->card_type == 1) ? "Student" : "Teacher";
            })
        	->toJson();
    }

	public function id_card()
    {
        return view('id_card/id_card');
    }

    public function idcard_form(Request $request)
    {
    	// dd($request->all());
    	if ($request->ajax()) {
    		if ($request->card_type == 1) {
		    	$rules = array(
		            'school_name' => 'required',
		            'student_name' => 'required',
		            'teacher_name' => 'required',
		            'dob' => 'required',
		            'display_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
		            'email' => 'required|email',
		        );
		    } else {
		    	$rules = array(
		            'school_name' => 'required',
		            'teacher_name' => 'required',
		            'phone_number' => 'required',
		            'address1' => 'required',
		            'city' => 'required',
		            'display_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
		            'email' => 'required|email',
		        );
		    }

	        $validator = Validator::make($request->all(), $rules);

	        if ($validator->fails()) {
	        	$result = ['status' => false, 'message' => $validator->errors(), 'data' => []];
	        } else {
	        	if ($request->form_type == 'submit') {
		        	$idcard = new IdCard;
		        	$idcard->id_number = $request->id_number;
		        	$idcard->card_type = $request->card_type;
		        	$idcard->card_color = $request->card_color;
		        	$idcard->school_name = $request->school_name;
		        	$idcard->school_year = $request->school_year;
		        	$idcard->student_grade = $request->student_grade;
		        	$idcard->student_name = $request->student_name;
		        	$idcard->teacher_name = $request->teacher_name;
		        	$idcard->dob = $request->dob;
		        	$idcard->phone_number = $request->phone_number;
		        	$idcard->address1 = $request->address1;
		        	$idcard->address2 = $request->address2;
		        	$idcard->city = $request->city;
		        	$idcard->email = $request->email;
		        	$idcard->print_free_card = 1;
		        	$idcard->updated_at = Carbon::now();

		        	if ($request->hasFile('display_photo')) {
	                    if ($idcard->display_photo != '') {
	                    	$file_path = public_path('uploads/idcard_photo') . $idcard->display_photo;
	                    	File::makeDirectory($file_path, $mode = 0777, true, true);

	                        if (file_exists($file_path)) {
	                            unlink(public_path('uploads/idcard_photo') . $idcard->display_photo);
	                        }
	                    }          
	                    
	                    $fileName = $request->file('display_photo')->hashName();
	                    $path = public_path('uploads/idcard_photo');
	                    request()->display_photo->move($path, $fileName);

	                    $idcard->display_photo = $fileName;
	                }

	                if ($idcard->save()) {
		        		$result = ['status' => true, 'message' => '', 'data' => $idcard, 'type' => 'submit'];
		        	} else {
	                    $result = ['status' => false, 'message' => 'Error in saving data', 'data' => []];
	                }
	            } else if ($request->form_type == 'preview') {
	            	$result = ['status' => true, 'message' => '', 'data' => $request->all(), 'type' => 'preview'];
	            } else {
	            	$result = ['status' => true, 'message' => '', 'data' => $request->all(), 'type' => 'email'];
	            }
	        }
	    } else {
	    	$result = ['status' => false, 'message' => 'Invalid request', 'data' => []];
	    }

        return response()->json($result);
    }

    public function preview_card($id)
    {
    	$data = IdCard::find($id);

    	return view('id_card/preview_card', compact('data'));
    }

    public function print_card($id)
    {
    	$data = IdCard::find($id);

    	return view('id_card/print_card', compact('data'));
    }

    public function print_canvas(Request $request)
    {
    	dd($request->all());
    }

    public function send_card(Request $request)
    {
	    $png_url = "id-card.png";
	    $path = public_path().'/card/' . $png_url;

	    $img = $request->image;
		$img = substr($img, strpos($img, ",")+1);
		$data2 = base64_decode($img);
		$success = file_put_contents($path, $data2);

	    $id_card_img = public_path('card/id-card.png');

    	$data["email"] = $request->email;
        $data["title"] = "ID Card";
        $data["image"] = $request->image;

        Mail::send('mail.send-card', $data, function($message)use($request, $id_card_img) {
        	$message->to($request->email);
        	$message->subject('ID Card');
            // $message->attachData(base64_decode($request->image), 'id-card.png', ['mime' => 'image/png']);
            // $message->embedData(base64_decode($request->image), 'id-card.png');
            $message->attach($id_card_img, ['as' => 'id-card.png', 'mime' => 'image/png']);
        });

        unlink('card/id-card.png');

        $result = ['status' => true, 'message' => 'Email sent successfully', 'data' => []];
        return response()->json($result);
    }
}

?>