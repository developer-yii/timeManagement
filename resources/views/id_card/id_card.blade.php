<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="">
	<meta name="decription" content="">
	<title>ID Card</title>

	<!-- Fav Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest')}}">

	<link href="{{ asset('css/app.min.css') }}" rel="stylesheet" id="app-style">
	<!-- Include Bootstrap -->
	<link rel="stylesheet" href="{{ asset('css/landing/bootstrap.css')}}" />
	
	<!-- Main StyleSheet -->
	<link rel="stylesheet" href="{{ asset('css/landing/style.css')}}" />	
	
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="{{ asset('css/landing/responsive.css')}}" />

	<link rel="stylesheet" href="{{ asset('css/custom.css')}}" />
	<link href="{{ asset('card/css/bootstrap.min.css')}}" rel="stylesheet">
	{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}
	<link href="{{ asset('card/css/style.css?v=111') }}" rel="stylesheet">
	<!-- third party css -->
    <link href="{{ asset('css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/vendor/jquery.serialtip.css') }}" rel="stylesheet" type="text/css" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</head>
<body style="color: #707070;">
	<div class="custom-container">
		<div id="home-body">
			<div class="row">
				<div class="column text left" style="margin-left:0px">
					<div class="centerAlign">
						<div class="text-black text-center">
							<div class="mb-5">
								<img src="{{ asset('images/pages/idcardbanner.png')}}">								
							</div>							

							<p>There are tons of great discounts that are available to teachers, students & homeschool educators!</p>
							<p class="hsbcid-header fs-3 font-bold">Download your IDs and take advantage of these discounts and more.</p>

								<p>Michaels - 15% Off</p>
								<p>Apple Computer</p>
								<p>Books-A-Million - 20% Off</p>
								<p>JoAnn Crafts</p>
								<p>Barnes and Noble Bookstore and more!</p>
							
							<p class="fs-3 font-bold fst-italic text-info">Print your school IDs today! Be sure to ask at every store and restaurant you visit if they offer a homeschool discount!</p>
							<br><br>


							Need help with tracking homeschool hours, your daily schedule, or just to making sure
							your kids are getting a balanced education?
							<br><br>
							<p class="font-bold">Visit <a href="https://www.homeschoolminutes.com">www.homeschoolminutes.com</a> today!</p>							
							<br>							
						</div>

						<form action="" method="post" name="id_card_form" class="id_card_form" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" value="" id="edit-id">
							<input type="hidden" name="form_type" class="form_type" value="submit">

							<div class="row" style="padding-top:30px; flex-wrap: nowrap;">
								<div class="one-third column photo-id">
									<div class="text-center" style="display: flex; justify-content: center;">
										<span id="current_preview">
											<div id="body-main-div" style="width: 324px !important; position: relative !important;">
												<img src="{{ asset('card/img/card-bg-student.png') }}" class="hide_for_teacher" style="width: 325px !important;">

												<img src="{{ asset('card/img/card-bg-teacher.png') }}" class="hide_for_student" style="width: 325px !important;">

												<p style="position: absolute !important; left: 108px !important; top: 0px !important; font-size: 14px !important; text-align: center !important; line-height: 20px !important; width: 208px !important; height: 39px !important; display: flex !important; justify-content: center !important; align-items: center !important;">
													<span class="school_card" style="color: #fff !important;">Johnson Family Homeschool</span>
												</p>

												<img src="{{ asset('card/img/student-img.png') }}" style="height: 105px !important; position: absolute !important; left: 20px !important; top: 50px !important; width: 94px !important;" class="hide_for_teacher">

												<img src="{{ asset('card/img/teacher-img.png') }}" style="height: 105px !important; position: absolute !important; left: 20px !important; top: 50px !important; width: 94px !important;" class="hide_for_student">

												<div class="append_card_img" style="display: none;">
													<img src="" id="preview_card_img" style="height: 105px !important; position: absolute !important; left: 20px !important; top: 50px !important; width: 94px !important;">
												</div>

												<p class="student_name_card hide_for_teacher" style="position: absolute !important; left: 129px !important; top:64px !important; font-weight: 700 !important; font-size: 11px !important; color: black !important;">Arianna Henry</p>

												<p class="teacher_name_card hide_for_student" style="position: absolute !important; left: 129px !important; top:64px !important; font-weight: 700 !important; font-size: 11px !important; color: black !important;">Sarah Miller</p>

												<p class="dob_card hide_for_teacher" style="position: absolute !important; left: 129px !important; top: 100px !important; font-weight: 700 !important; font-size: 11px !important; line-height: 14px; color: black !important;">02/03/2014</p>

												<p class="address_card hide_for_student" style="position: absolute !important; left: 129px !important; top:95px !important; font-weight: 700 !important; font-size: 11px !important; line-height: 11px; text-align: left; color: black !important;">
													<span class="address_card1">1296</span><br>
													<span class="address_card2">Farmton Lane Hills</span><br>
													<span class="address_card3">NY 63251</span>
												</p>

												<p class="educator_card hide_for_teacher" style="position: absolute !important; left: 129px !important; top:131px !important; font-weight: 700 !important; font-size: 11px !important; color: black !important;">Sandra Henry</p>

												<p class="phone_card hide_for_student" style="position: absolute !important; left: 129px !important; top:139px !important; font-weight: 700 !important; font-size: 11px !important; color: black !important;">111-111-1111</p>

												@php
												$id_number = random_int(10000000, 99999999);
												@endphp
												<p style="position: absolute !important; left: 234px !important; top:64px !important; font-weight: 700 !important; font-size: 11px !important; color: black !important;">{{ $id_number }}</p>
												<input type="hidden" name="id_number" class="id_number" value="{{ $id_number }}">

												<p class="year_card" style="position: absolute !important; left: 20px !important; top: 181px !important; font-size: 13px !important; text-align: center !important; color: #fff !important; line-height: 20px;">2022 - 2023</p>

												<p class="grade_card hide_for_teacher" style="position: absolute !important; left: 235px !important; top:100px !important; font-weight: 700 !important; font-size: 25px !important; line-height: 39px !important; text-transform: uppercase !important; display: block !important; text-align: center !important; padding: 5px 0 !important; width: 35px !important; color: black !important;">
													<span>3</span>
												</p>
											</div>

											{{-- <div class="v-card" id="v-card" style="width:358px;height:230px;position:relative">
												<div class="top">
													<span class="school_card" style="text-align: center; margin-left: 90px;">Johnson Family Homeschool</span>
												</div>

												<div class="middle">
													<div class="left hide_for_teacher">
														<img src="{{ asset('card/img/student-img.png') }}" class="student_img_card" style="height: 111px; width: 90px;">
													</div>

													<div class="left hide_for_student">
														<img src="{{ asset('card/img/teacher-img.png') }}" class="teacher_img_card" style="height: 111px; width: 90px;">
													</div>

													<div class="left append_card_img" style="display: none;">
														<img src="" id="preview_card_img" style="height: 111px; width: 90px;">
													</div>

													<div class="right">
														<div class="row" style="flex-wrap: nowrap;">
															<div class="col-xs-7">
																<div class="text-field hide_for_teacher">
																	<span class="label">STUDENT</span>
																	<p class="student_name_card">Arianna Henry</p>
																</div>

																<div class="text-field hide_for_student" style="margin-bottom: 16px !important;">
																	<span class="label">HOME EDUCATOR</span>
																	<p class="teacher_name_card">Sarah Miller</p>
																</div>

																<div class="text-field hide_for_teacher">
																	<span class="label">DATE OF BIRTH</span>
																	<p class="dob_card">02/03/2014</p>
																</div>

																<div class="text-field hide_for_student" style="margin-bottom: 37px !important;">
																	<span class="label">ADDRESS</span>
																	<p class="address_card" style="width: 200%; overflow: unset;">
																		<span class="address_card1">1296</span><br>
																		<span class="address_card2">Farmton Lane Hills</span><br>
																		<span class="address_card3">NY 63251</span>
																	</p>
																</div>

																<div class="text-field mb0 hide_for_teacher">
																	<span class="label">HOME EDUCATOR</span>
																	<p class="educator_card">Sandra Henry</p>
																</div>

																<div class="text-field mb0 hide_for_student">
																	<span class="label">PHONE</span>
																	<p class="phone_card">111-111-1111</p>
																</div>
															</div>

															<div class="col-xs-5">
																<div class="text-field">
																	<span class="label">ID NUMBER</span>
																	@php
																	$id_number = random_int(10000000, 99999999);
																	@endphp
																	<p>{{ $id_number }}</p>
																	<input type="hidden" name="id_number" class="id_number" value="{{ $id_number }}">
																</div>

																<div class="gradebox hide_for_teacher">
																	<span>Grade</span>
																	<p class="grade_card">3</p>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="bottom">
													<div class="bleft">
														<span class="student_id_card hide_for_teacher">STUDENT ID</span>
														<span class="teacher_id_card hide_for_student" style="margin-bottom: 3px !important;">TEACHER ID</span>
														<span class="year_card">2022 - 2023</span>
													</div>

													<div class="img">
														<img src="{{ asset('card/img/home-logo.png') }}" style="height: 28px;" />
													</div>
												</div>
											</div> --}}
										</span>
									</div>

									<div style="padding-top:20px;">
										<div class="column">
											<span class="spacer"></span>

											<div class="button-center text-center">
												<input type="submit" name="asubmitbutton" value="Print School ID" class="display_printable_page select_card_type btn btn-success">

												<input type="submit" name="asubmitbutton" value="Email School ID" class="email_printable_page btn btn-success">
						 					</div>
										</div>
									</div>

									<div class="text-center" style="width: 324px; margin: 45px auto 0 auto;">
				 						<p>* Want to keep your school ID's conveniently on your phone? Click the Email School ID above.</p>
				 					</div>
								</div>

								<div class="two-thirds column photo-id">
									<div id="id_card_form">
										<div class="row">
											<div class="column text-center">
												<div class="checkbox">
													<input type="radio" name="card_type" id="student-id" checked="" value="1" class="toggle_appropriate_fields">
													<label for="student-id" style="display: inline; margin-bottom: 0 !important; padding-left: 0;">&nbsp;STUDENT ID</label>

													<span class="spacer"></span>

													<input type="radio" name="card_type" id="teacher-id" value="2" class="toggle_appropriate_fields">
													<label for="teacher-id" style="display: inline; margin-bottom: 0 !important; padding-left: 0;">&nbsp;TEACHER ID</label>
												</div>
											</div>
										</div>

										{{-- <div class="row">
											<div class="column">
												<div class="checkbox">
													<input type="radio" name="card_color" id="color-green" checked="" value="1" class="toggle_appropriate_fields">
													<label for="color-green" style="display: inline; margin-bottom: 0 !important;">&nbsp;GREEN</label>

													<span class="spacer"></span>

													<input type="radio" name="card_color" id="color-aqua" value="2" class="toggle_appropriate_fields">
													<label for="color-aqua" style="display: inline; margin-bottom: 0 !important;">&nbsp;AQUA</label>
												</div>
											</div>
										</div> --}}

										<div class="row">
											<div class="one-half column">
												<input type="text" name="teacher_name" id="teacher_name" class="id_data_field form-control" value="" placeholder="Teacher Name">
												<span class="error"></span>
											</div>

											<div class="one-half column">
												<input type="text" name="student_name" id="student_name" class="id_data_field disable_for_teacher form-control" value="" placeholder="Student Name">
												<span class="error"></span>
											</div>
										</div>

										<div class="row">
											<div class="one-half column">
												<input type="text" name="school_name" id="school_name" class="id_data_field form-control" size="25" value="" placeholder="Your School Name">
												<span class="error"></span>
											</div>

											<div class="one-half column">
												<input type="text" name="dob" id="dob" class="id_data_field disable_for_teacher form-control" size="10" value="" placeholder="Date Of Birth (MM/DD/YYYY)" autocomplete="off" maxlength="10">
												<span class="error"></span>
											</div>
										</div>

										<div class="row">
											<div class="one-half column">
												<select name="school_year" id="school_year" class="id_data_field form-control">
													@php
													$current_year = date('Y');
													$minus_one = date('Y', strtotime('-1 year'));
													$plus_one = date('Y', strtotime('+1 year'));
													$plus_two = date('Y', strtotime('+2 year'));
													$plus_three = date('Y', strtotime('+3 year'));
													$plus_four = date('Y', strtotime('+4 year'));
													@endphp

													<option value="{{ $minus_one }} - {{ $current_year }}">{{ $minus_one }} - {{ $current_year }}</option>
													<option value="{{ $current_year }} - {{ $plus_one }}">{{ $current_year }} - {{ $plus_one }}</option>
													<option value="{{ $plus_one }} - {{ $plus_two }}">{{ $plus_one }} - {{ $plus_two }}</option>
													<option value="{{ $plus_two }} - {{ $plus_three }}">{{ $plus_two }} - {{ $plus_three }}</option>
													<option value="{{ $plus_three }} - {{ $plus_four }}">{{ $plus_three }} - {{ $plus_four }}</option>
												</select>
												<span class="error"></span>
											</div>

											<div class="one-half column">
												<select name="student_grade" id="student_grade" class="id_data_field disable_for_teacher form-control">
													<option value="P" selected="">P</option>
													<option value="K">K</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
												</select>
												<span class="error"></span>
											</div>
										</div>

										<div class="row">
											<div class="column">
												<input type="text" name="phone_number" id="phone_number" class="id_data_field disable_for_student form-control" size="15" value="" placeholder="Phone Number" maxlength="12">
												<span class="error"></span>
											</div>
										</div>

										<div class="row">
											<div class="column">
												<input type="text" name="address1" id="address1" class="id_data_field disable_for_student form-control" size="18" value="" placeholder="Address 1">
												<span class="error"></span>
											</div>
										</div>

										<div class="row">
											<div class="column">
												<input type="text" name="address2" id="address2" class="id_data_field disable_for_student form-control" size="8" value="" placeholder="Address 2">
												<span class="error"></span>
											</div>
										</div>

										<div class="row">
											<div class="column">
												<input type="text" name="city" id="city" class="id_data_field disable_for_student form-control" size="20" value="" placeholder="City, State, Zip">
												<span class="error"></span>
											</div>
										</div>

										<div class="row">
											<div class="column">
												<input type="text" name="email" id="email" class="form-control" size="30" value="" placeholder="Email Address">
												<span class="error"></span>
											</div>
										</div>

										<div class="row">
											<div class="column upload">
												<p>UPLOAD PHOTO</p>
												<p>(GIF, JPEG, JPG or PNG. Max size 1 MB)</p>
											</div>
										</div>

										<div class="row">
											<div class="one-half column">
												<input type="file" name="display_photo" id="display_photo" accept="image/png, image/gif, image/jpeg" onchange="document.getElementById('preview_card_img').src = window.URL.createObjectURL(this.files[0])">
												<span class="error"></span>
											</div>

											<div class="one-half column">
												<div>
													<input type="submit" name="asubmitbutton" class="update_preview btn btn-success" value="Update Preview">
												</div>
												<p></p>
											</div>
										</div>

										<div class="row">
											<div class="column">
												<input type="radio" name="print_free_card" id="print_free_card" value="email" checked>
												<label for="print_free_card" style="display: inline;"> By using our FREE ID app, you agree to receive homeschool promotional emails, discounts, and exciting new updates.</label>
											</div>
										</div>

										<div class="row" style="font-size:12pt;padding-top:10px;">
											<div class="column">* As a security precaution, we do not print addresses or phone numbers on the Student ID.</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<input type="file" name="id_file" class="hiddeninput" style="position: absolute; margin: -5px 0px 0px -175px; padding: 0px; width: 220px; height: 30px; font-size: 14px; opacity: 0; cursor: pointer; display: block; z-index: 2147483583; top: 1162px; left: 616px;">

	<!-- Main jQuery -->
	<script src="{{ asset('js/landing/jquery-3.4.1.min.js')}}"></script>		

	<!-- Bootstrap Bundle jQuery -->
	<script src="{{ asset('js/landing/bootstrap.bundle.min.js')}}"></script>

	<!-- Fontawesome Script -->
	<script src="https://kit.fontawesome.com/7749c9f08a.js"></script>

	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> --}}

	<script src="{{ asset('js/vendor.min.js') }}"></script>
	<script src="{{ asset('js/app.min.js') }}"></script>
	<script src="{{ asset('js/html2canvas.js') }}"></script>

	<script type="text/javascript">
		function show_toast(toast_message,toast_type) {
            if(toast_type == 'success')
                $.NotificationApp.send("Success!", toast_message, "top-right", "rgba(0,0,0,0.2)", toast_type);
            else if(toast_type == 'error')
                $.NotificationApp.send("", toast_message, "top-right", "rgba(0,0,0,0.2)", toast_type);
        }

		var addUrl = "{{ route('idcard_form') }}";
		var previewCardUrl = "{{ route('preview_card') }}";
		var sendCardUrl = "{{ route('send_card') }}";
		var isPrint = false;
		var isCard = true;
		var _token = "{{ csrf_token() }}";
	</script>

	<script src="{{ asset('js/page/id-card.js') }}"></script>
</body>
</html>