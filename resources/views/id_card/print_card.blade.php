<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="icon" href="img/favicon.png"> --}}
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
	<link href="{{ asset('card/css/style.css?v=123') }}" rel="stylesheet">
	<script src="{{ asset('card/js/jquery.min.js') }}"></script>
	<script src="{{ asset('card/js/bootstrap.min.js') }}"></script>
</head>
<body class="custom-body" style="font-family: 'CenturyGothic', sans-serif !important; font-weight: 400 !important; font-size: 16px !important; line-height: 20px !important;">
	<div id="body-main-div">
		@if ($data->card_type == 1)
			<img src="{{ asset('card/img/card-bg-student.png') }}" style="width: 32%;">
		@else
			<img src="{{ asset('card/img/card-bg-teacher.png') }}" style="width: 32%;">
		@endif

		<p style="position: absolute !important; left: 151px !important; top:19px !important; font-size: 19px !important; color: #fff !important; text-align: center !important; line-height: 20px !important; width: 272px !important;"><span>{{ $data->school_name }}</span></p>

		<img src="{{ asset('uploads/idcard_photo/'.$data->display_photo) }}" style="height: 141px !important; position: absolute !important; left: 27px !important; top:67px !important; width: 125px !important;">

		<p style="position: absolute !important; left: 174px !important; top:87px !important; font-weight: 700 !important; font-size: 13px !important;">@if ($data->card_type == 1) {{ $data->student_name }} @else {{ $data->teacher_name }} @endif</p>

		@if ($data->card_type == 1)
			<p style="position: absolute !important; left: 174px !important; top:136px !important; font-weight: 700 !important; font-size: 13px !important; width: 410px !important; line-height: 14px;">{{ $data->dob }}</p>
		@else
			<p style="position: absolute !important; left: 174px !important; top:127px !important; font-weight: 700 !important; font-size: 13px !important; width: 410px !important; line-height: 14px;">{{ $data->address1 }} <br> {{ $data->address2 }} <br> {{ $data->city }}</p>
		@endif

		@if ($data->card_type == 1)
			<p style="position: absolute !important; left: 174px !important; top:178px !important; font-weight: 700 !important; font-size: 13px !important;">{{ $data->teacher_name }}</p>
		@else
			<p style="position: absolute !important; left: 174px !important; top:187px !important; font-weight: 700 !important; font-size: 13px !important;">{{ $data->phone_number }}</p>
		@endif

		<p style="position: absolute !important; left: 316px !important; top:87px !important; font-weight: 700 !important; font-size: 13px !important;">{{ $data->id_number }}</p>

		<p style="position: absolute !important; left: 23px !important; top: 247px !important; font-size: 18px !important; text-align: center !important; color: #fff !important; line-height: 20px;">{{ $data->school_year }}</p>

		@if ($data->card_type == 1)
			<p style="position: absolute !important; left: 318px !important; top:137px !important; font-weight: 700 !important; font-size: 35px !important; line-height: 50px !important; text-transform: uppercase !important; display: block !important; text-align: center !important; padding: 5px 0 !important; width: 46px !important;"><span>{{ $data->student_grade }}</span></p>
		@endif
	</div>

	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> --}}
	<script src="{{ asset('js/html2canvas.js') }}"></script>

	<script type="text/javascript">
		var isPrint = true;
		var isCard = false;
	</script>

	<script src="{{ asset('js/page/id-card.js') }}"></script>
</body>
</html>