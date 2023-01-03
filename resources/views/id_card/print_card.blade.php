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
	@if ($data->card_type == 1)
		<img src="{{ asset('card/img/card-bg-student.png') }}" />
	@else
		<img src="{{ asset('card/img/card-bg-teacher.png') }}" />
	@endif

	<p style="position: absolute; left: 350px; top:34px; font-size: 32px; color: #fff !important; text-align: right; line-height: 20px;">{{ $data->school_name }}</p>

	<img src="{{ asset('uploads/idcard_photo/'.$data->display_photo) }}" style="max-height: 247px; position: absolute; left: 45px; top:105px;">

	<p style="position: absolute; left: 289px; top:155px; font-weight: 700; font-size: 20px; max-height: 40px;">@if ($data->card_type == 1) {{ $data->student_name }} @else {{ $data->teacher_name }} @endif</p>

	<p style="position: absolute; left: 289px; top:231px; font-weight: 700; font-size: 20px; max-height: 40px;">@if ($data->card_type == 1) {{ $data->dob }} @else {{ $data->address1 }} {{ $data->address2 }}, {{ $data->city }} @endif</p>

	<p style="position: absolute; left: 289px; top:307px; font-weight: 700; font-size: 20px; max-height: 40px;">@if ($data->card_type == 1) {{ $data->teacher_name }} @else {{ $data->phone_number }} @endif</p>

	<p style="position: absolute; left: 525px; top:154px; font-weight: 700; font-size: 20px; max-height: 40px;">{{ $data->id_number }}</p>

	<p style="position: absolute; left: 42px; top: 420px; font-size: 28px; text-align: center; color: #fff !important; line-height: 20px;">{{ $data->school_year }}</p>

	@if ($data->card_type == 1)
		<p style="position: absolute; left: 546px; top:246px; font-weight: 700; font-size: 64px; line-height: 50px; text-transform: uppercase; display: block; text-align: center; padding: 5px 0;">{{ $data->student_grade }}</p>
	@endif

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

	<script type="text/javascript">
		var isPrint = true;
	</script>

	<script src="{{ asset('js/page/id-card.js') }}"></script>
</body>
</html>