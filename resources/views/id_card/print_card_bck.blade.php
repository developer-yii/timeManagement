<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/favicon.png">
    <title>ID Card</title>
	<meta name="description"  content="" />
	<meta name="keywords"  content="" />

	<!-- Fav Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest')}}">

	<link href="{{ asset('card/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('card/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('card/css/style-org.css') }}" rel="stylesheet">
	<script src="{{ asset('card/js/jquery.min.js') }}"></script>
	<script src="{{ asset('card/js/bootstrap.min.js') }}"></script>
</head>
<body>
	<img src="" class="append_canvas" style="display: none;">

	<div class="v-card" id="print-v-card">
		<div class="top">
			<span style="text-align: center; margin-left: 150px;">{{ $data->school_name }}</span>
		</div>
		<div class="middle">
			<div class="left">
				<img src="{{ asset('uploads/idcard_photo/'.$data->display_photo) }}" style="max-height: 247px;">
			</div>

			<div class="right">
				<div class="row">
					<div class="col-xs-7">
						<div class="text-field">
							@if ($data->card_type == 1)
								<span class="label">STUDENT</span>
								<p>{{ $data->student_name }}</p>
							@else
								<span class="label">HOME EDUCATOR</span>
								<p>{{ $data->teacher_name }}</p>
							@endif
						</div>
						<div class="text-field">
							@if ($data->card_type == 1)
								<span class="label">DATE OF BIRTH</span>
								<p>{{ $data->dob }}</p>
							@else
								<span class="label">ADDRESS</span>
								<p>{{ $data->address1 }} {{ $data->address2 }}, {{ $data->city }}</p>
							@endif
						</div>
						<div class="text-field mb0">
							@if ($data->card_type == 1)
								<span class="label">HOME EDUCATOR</span>
								<p>{{ $data->teacher_name }}</p>
							@else
								<span class="label">PHONE</span>
								<p>{{ $data->phone_number }}</p>
							@endif
						</div>
					</div>

					<div class="col-xs-5">
						<div class="text-field">
							<span class="label">ID NUMBER</span>
							<p>{{ $data->id_number }}</p>
						</div>

						@if ($data->card_type == 1)
							<div class="gradebox">
								<span>Grade</span>
								<p>{{ $data->student_grade }}</p>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div class="bottom">
			<div class="bleft"><span>STUDENT ID</span><span>{{ $data->school_year }}</span></div>
			<div class="img">
				{{-- <img src="{{ asset('card/img/home-logo.png') }}" /> --}}
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
	<script src="{{ asset('js/page/id-card.js') }}"></script>
</body>
</html>