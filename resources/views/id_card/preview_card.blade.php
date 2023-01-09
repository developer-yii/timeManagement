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

	<!-- Include Bootstrap -->
	<link rel="stylesheet" href="{{ asset('css/landing/bootstrap.css')}}" />
	
	<!-- Main StyleSheet -->
	<link rel="stylesheet" href="{{ asset('css/landing/style.css')}}" />	
	
	<!-- Responsive CSS -->
	<link rel="stylesheet" href="{{ asset('css/landing/responsive.css')}}" />

	<link rel="stylesheet" href="{{ asset('css/custom.css')}}" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link href="{{ asset('card/css/style.css?v=123') }}" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</head>
<body style="color: #707070;">
	<div class="custom-container">
		<div id="home-body">
			<div class="row">
				<div class="column text left" style="margin-left:0px">
					<div class="centerAlign">
						<h1 style="color: #2dc33b !important;"><b>Print Instructions:</b></h1>
						<br>
						{{-- Below is a link to a printable page with the Homeschool ID card you just created.  For your benefit, please read ALL of the instructions on this page before you proceed.
						<br>
						<br> --}}

						<b>Please click the link below to print your ID card.  You can print this on card stock and laminate it for durability.</b>
						<br>
						<br>

						If your print box does not come up, you can use Ctrl P to bring up your print box or save it as a PDF.
						<br>
						<br>

						<a href="{{ route('print_card', ['id' => $data->id]) }}" data-id="{{ $data->id }}" class="print_img">{{ route('print_card', ['id' => $data->id]) }}</a>
						<br><br>

						Below is the HTML code for our SCHOOL ID.  Please feel free to paste this on social media, your website, or your blog.  This will help let other parents know how they can get their FREE ID card!
						<br><br>

						<table class="cus_table">
							<tbody>
								<tr>
									<td>
										<img src="{{ asset('card/img/sample-id.png') }}" style="width: 200px; margin-right: 30px;">
									</td>

									<td>
										<textarea readonly="" rows="4" cols="56">&lt;table width=150px&gt;&lt;tr&gt;&lt;td&gt;&lt;a href="{{ route('id_card') }}"&gt;&lt;img src="{{ asset('card/img/sample-id.png') }}" border=0&gt;&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;a href="{{ route('id_card') }}"&gt;&lt;center&gt;Get a &lt;b&gt;FREE&lt;/b&gt;&lt;br/&gt;Homeschool ID Card!&lt;/a&gt;&lt;/center&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;</textarea>
									</td>
								</tr>
							</tbody>
						</table>
						<br>

						<b>Thank you for helping us get the word out.</b>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

	<script type="text/javascript">
		var isPrint = false;
		var isCard = false;
	</script>

	<script src="{{ asset('js/page/id-card.js') }}"></script>
</body>
</html>