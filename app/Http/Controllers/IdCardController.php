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
    	// dd($request->all());

    	$id_number = $request->id_number;
    	$school_name = $request->school_name;
    	$teacher_name = $request->teacher_name;
    	$student_name = $request->student_name;
    	$dob = $request->dob;
    	$school_year = $request->school_year;
    	$student_grade = $request->student_grade;
    	$phone_number = $request->phone_number;
    	$address1 = $request->address1;
    	$address2 = $request->address2;
    	$city = $request->city;
    	$image = $request->image;

	    // $png_url = "id-card-copy.png";
    	// $path = public_path().'/card/' . $png_url;
    	// $save_img = file_put_contents($path, $image);

    	if ($request->hasFile('display_photo')) {
	    	// $fileName = $request->file('display_photo')->hashName();
	    	$fileName = $_FILES['display_photo']['tmp_name'];
    		imagepng(imagecreatefromstring(file_get_contents($fileName)), public_path().'/card/id-card-copy.png');

	        // $path = public_path('card');
	        // request()->display_photo->move($path, $fileName);
	    }

    	$iddir = public_path().'/card';
    	// $profileimage = public_path().'/card/img/student-img.png';
    	$profileimage = public_path().'/card/id-card-copy.png';
    	// $font_size = 13;
    	$font_file = public_path().'/card/fonts/CenturyGothic.ttf';
    	$img = public_path().'/card/final.png';

    	$img2 = $iddir.'/id-card.png';

    	$virtualprofile = imagecreatefrompng($profileimage);
    	list($profilewid, $profilehayt) = getimagesize($profileimage);
    	$newprofilewid = 94;
		$newprofilehayt = 105;

		$destination = imagecreatetruecolor($newprofilewid, $newprofilehayt);
		imagecopyresampled($destination, $virtualprofile, 0, 0, 0, 0, $newprofilewid, $newprofilehayt, $profilewid, $profilehayt);
		imagejpeg($destination, public_path().'/card/tmp.jpg', 100);

		if ($request->card_type == 1) {
			$backgroundimage = imagecreatefrompng(public_path().'/card/img/card-bg-student.png');
			$aaa = public_path().'/card/img/card-bg-student.png';
		} else {
			$backgroundimage = imagecreatefrompng(public_path().'/card/img/card-bg-teacher.png');
			$aaa = public_path().'/card/img/card-bg-teacher.png';
		}

		list($width, $height) = getimagesize($aaa);
    	$new_width = 324;
		$new_height = 204;
		$destination2 = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($destination2, $backgroundimage, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagejpeg($destination2, public_path().'/card/tmp2.jpg', 100);

		$backgroundimage2 = imagecreatefromjpeg(public_path().'/card/tmp2.jpg');

		$profilestamp = imagecreatefromjpeg(public_path().'/card/tmp.jpg');

		$marge_right = 210;
		$marge_bottom = 50;

		$sx = imagesx($profilestamp);
		$sy = imagesy($profilestamp);

		$xcoordest = imagesx($backgroundimage2) - $sx - $marge_right;
		$ycoordest = imagesy($backgroundimage2) - $sy - $marge_bottom;

		imagecopymerge($backgroundimage2, $profilestamp, $xcoordest, $ycoordest, 0, 0, $sx, $sy, 100);

		imagepng($backgroundimage2, public_path().'/card/final.png');
		imagedestroy($backgroundimage2);

		$im = imagecreatefrompng($img);
		$textcolor = imagecolorallocate($im, 0, 0, 0);

		$image_width = imagesx($im);  
		$image_height = imagesy($im);

		imagettftext($im, 8, 0, 235, 78, $textcolor, $font_file, $id_number);
		imagettftext($im, 11, 0, 140, 24, imagecolorallocate($im, 255, 255, 255), $font_file, $school_name);
		imagettftext($im, 10, 0, 20, 196, imagecolorallocate($im, 255, 255, 255), $font_file, $school_year);

		if ($request->card_type == 1) {
			imagettftext($im, 8, 0, 130, 78, $textcolor, $font_file, $student_name);
			imagettftext($im, 8, 0, 130, 146, $textcolor, $font_file, $teacher_name);
			imagettftext($im, 8, 0, 130, 112, $textcolor, $font_file, $dob);

			if (($student_grade == 10) || ($student_grade == 11) || ($student_grade == 12)) {
				imagettftext($im, 12, 0, 246, 130, $textcolor, $font_file, $student_grade);
			} else {
				imagettftext($im, 12, 0, 248, 130, $textcolor, $font_file, $student_grade);
			}
		} else {
			imagettftext($im, 8, 0, 130, 78, $textcolor, $font_file, $teacher_name);
			imagettftext($im, 8, 0, 130, 152, $textcolor, $font_file, $phone_number);
			imagettftext($im, 8, 0, 130, 106, $textcolor, $font_file, $address1);
			imagettftext($im, 8, 0, 130, 116, $textcolor, $font_file, $address2);
			if ($address2 != '') {
				imagettftext($im, 8, 0, 130, 126, $textcolor, $font_file, $city);
			} else {
				imagettftext($im, 8, 0, 130, 116, $textcolor, $font_file, $city);
			}
		}

		imagepng($im, $img2, 9);
		imagedestroy($im);

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

		unlink(public_path().'/card/id-card.png');
		unlink(public_path().'/card/id-card-copy.png');
		unlink(public_path().'/card/final.png');
		unlink(public_path().'/card/tmp.jpg');
		unlink(public_path().'/card/tmp2.jpg');


	    // $path = public_path().'/card/' . $png_url;

	    // $img = $request->image;
		// $img = substr($img, strpos($img, ",")+1);
		// $data2 = base64_decode($img);
		// $success = file_put_contents($path, $data2);

        // unlink('card/id-card.png');

        $result = ['status' => true, 'message' => 'Email sent successfully', 'data' => []];
        return response()->json($result);
    }
}

?>