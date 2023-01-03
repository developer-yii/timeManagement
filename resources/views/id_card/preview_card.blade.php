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
	<link href="{{ asset('card/css/style.css') }}" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
</head>
<body style="color: #707070;">
	<div class="custom-container">
		<div id="home-body">
			<div class="row">
				<div class="column text left" style="margin-left:0px">
					<div class="centerAlign">
						<h1><b>INSTRUCTIONS:</b></h1>
						Below is a link to a printable page with the Homeschool ID card you just created.  For your benefit, please read ALL of the instructions on this page before you proceed.
						<br>
						<br>

						<b>1.  Click the link below to go to your design: </b>
						<br>
						<br>

						<a href="{{ route('print_card', ['id' => $data->id]) }}" data-id="{{ $data->id }}" class="print_img">{{ route('print_card', ['id' => $data->id]) }}</a>
						<br><br>

						<b>2.  Use your browser's Print command to print the design on the printer/paper of your choice.</b>
						<br>
						<br>

						<b><u>GETTING A DURABLE PLASTIC (PVC) CARD: </u></b>
						<br>

						For the highest quality ID card at a low price, come back to the Homeschool Buyers Club website and order professionally printed cards from the Club <u>for $7.95</u>.  We print high quality images on the same kind of PVC plastic as your credit card: 
						<br>
						<br>

						<a href="{{ route('id_card') }}">
							<b>{{ route('id_card') }}</b>
						</a>
						<br>
						<br>

						Your full satisfaction is guaranteed, excluding data entry errors on your part.<br>
						<br>

						<h2><b>HELP US SPREAD THE WORD!</b></h2>
						<br>

						Please tell your homeschool friends about the Club and this free service.  The more members we have, the more services we are able to provide.
						<br>
						<br>

						You can also help us spread the word by publishing the following HTML on your blog or website:
						<br>
						<br>

						<table>
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

						The HTML will cause the thumbnail image shown above to display on your blog or website.
						<br>
						<br>

						We appreciate you at the Club!
						<br>
						<br>

						Homeschool Buyers Club
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

	<script type="text/javascript">
		var isPrint = false;
	</script>

	<script src="{{ asset('js/page/id-card.js') }}"></script>
</body>
</html>