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
						<div style="text-align: center;">
							<h2 class="hsbcid-header">
								<span>FREE Student & Teacher (parent) ID!</span>
							</h2>

							There are tons of great discounts that are available to teachers. What many parents aren’t aware of is that many <u>are available to homeschool families with a valid School ID.</u>
							<br><br>

							Fill out the form below, click “Update Preview” to make sure everything is entered correctly then click “Print School ID”.
							<br><br>

							<h4>It’s that easy!</h4>
							<br>

							Then visit our directory to see current discounts we found.
							<br>

							<a href="https://www.homeschoolnextdoor.com">www.homeschoolnextdoor.com</a>
						</div>

						<form action="" method="post" name="id_card_form" class="id_card_form" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" value="" id="edit-id">
							<input type="hidden" name="form_type" class="form_type" value="submit">

							<div class="row" style="padding-top:30px; flex-wrap: nowrap;">
								<div class="one-third column photo-id">
									<div class="text-center">
										<span id="current_preview">
											<div class="v-card" style="width:358px;height:230px;position:relative">
												<div class="top">
													<span class="school_card">Johnson Family Homeschool</span>
												</div>

												<div class="middle">
													<div class="left hide_for_teacher">
														<img src="{{ asset('card/img/student-img.png') }}" class="student_img_card" style="height: 100%;">
													</div>

													<div class="left hide_for_student">
														<img src="{{ asset('card/img/teacher-img.png') }}" class="teacher_img_card" style="height: 100%;">
													</div>

													<div class="left append_card_img" style="display: none;">
														<img src="" id="preview_card_img" style="height: 100%;">
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
											</div>
										</span>
									</div>

									<div style="padding-top:20px;">
										<div class="column">
											<span class="spacer"></span>

											<div class="button-center text-center">
												<input type="submit" name="asubmitbutton" value="Print School ID" class="display_printable_page select_card_type btn btn-success">
						 					</div>
										</div>
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
												<label for="print_free_card" style="display: inline;"> To use our FREE service. You agree to receive homeschooling promotional messages, discounts, and exciting new updates.</label>
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

	<input type="file" name="id_file" style="position: absolute; margin: -5px 0px 0px -175px; padding: 0px; width: 220px; height: 30px; font-size: 14px; opacity: 0; cursor: pointer; display: block; z-index: 2147483583; top: 1162px; left: 616px;">

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
		var addUrl = "{{ route('idcard_form') }}";
		var previewCardUrl = "{{ route('preview_card') }}";
		var isPrint = false;
		var isCard = true;
	</script>

	<script src="{{ asset('js/page/id-card.js') }}"></script>
</body>
</html>