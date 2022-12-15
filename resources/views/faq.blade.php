<!DOCTYPE html>
<html lang="en-US">
	<head>
		<!-- Meta setup -->
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="keywords" content="">
		<meta name="decription" content="">
		
		<!-- Title -->
		<title>Welcome</title>
		
		<!-- Fav Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png')}}">
	    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png')}}">
	    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png')}}">
	    <link rel="manifest" href="{{ asset('images/site.webmanifest')}}">	

		<!-- Include Bootstrap -->
		<link rel="stylesheet" href="{{ asset('css/landing/bootstrap.css')}}" />
		
		<!-- Main StyleSheet -->
		<link rel="stylesheet" href="{{ asset('css/landing/style.css')}}?{{time()}}" />
		
		<!-- Responsive CSS -->
		<link rel="stylesheet" href="{{ asset('css/landing/responsive.css')}}?{{time()}}" />	
		
	</head>
	<body>

		<!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

		<!-- header-area start -->	
		<header class="header-area">
			<div class="container">
				<div class="header-item">
					<nav class="navbar navbar-expand-md">				    <a href="#" class="navbar-brand"><img src="{{ asset('images/landing/logo.png')}}" alt="" /></a>
						<div class="navbar-toggler hamburger hamburger--springr" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						    <div class="hamburger-box">
						    	<div class="hamburger-inner"></div>
						    </div>
						</div>
					    <div class="collapse navbar-collapse" id="navbarNav">
					      <ul class="navbar-nav">
						      	<li class="nav-item">
						        	<a class="nav-link" href="{{ route('index')}}">Home</a>
						      	</li>
						      	{{-- <li class="nav-item">
						        	<a class="nav-link" href="#">Price</a>
						      	</li> --}}
						      	<li class="nav-item">
						        	<a class="nav-link selected" href="{{ route('faq') }}">Price & FAQ</a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link" href="{{ route('login')}}">Login</a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link mr-1" href="{{ route('register')}}">FREE TRIAL</a>
						      	</li>
					    	</ul>
					    </div>
					</nav>							
				</div>					
			</div>
		</header>	
		<!-- header-area end -->

		<!-- planner-area start -->
		<div class="planner-area planner-area2">
			<div class="planner-item">
				<img src="{{ asset('images/landing/08.png')}}" alt="" />
			</div>
			<div class="planner-area-inner">
				<div class="container">
					<div class="planner-item2">
						<h2>Information & Pricing</h2>
						<a href="{{ route('register')}}">FREE 14 DAY TRIAL</a>
					</div>
				</div>
			</div>
		</div>		
		<!-- planner-area end -->

		<!-- tracking-area start -->	
		<div class="tracking-area tracking-area2">
			<div class="container">
				<div class="tracking-item">
					<h3>Q. Can I use this app for my entire family?</h3>
					<h5>Yes!  You can schedule doctor appointments, work hours, and more through the events/holidays tab.</h5>
					<h3>Q. I have 5 children, Do I need to sign up for each child?</h3>
					<h5>You only have to sign up once! Enter all of your children<br> for only $4.95 per month.  You can view each child individually.</h5>
					<h3>Q. What exactly does it keep track of?</h3>
					<h5>Everything!  It will track your hours, subject type, attendance and daily schedule. Then it loads all this information into our easy to read dashboard.  There are over 16 states that require hours, attendace or both.</h5>
					<h3>Q. How complicated is it?</h3>
					<h5>Super easy!  We wanted to make this as easy as filling out a day planner, but without all the extra paper and post it notes. It is also available on your phone so you can take it anywhere.</h5>
					<h3>Q. What if I need help?</h3>
					<h5>We post helpful hints in our app, but always feel free <br>to reach out to us with questions.</h5>
					<h3>Q. How much does it cost?</h3>
					<h5>Only $5.95 per month!  That’s it.</h5>
					<h3>Q. What do I get for $5.95 per month?</h3>
					<h5>Besides your sanity?<span>Less clutter and paper.</span><span>A full day planner not just for the kiddos, but the adults as well.</span> <span>Automatically calculated hours and attendance.</span><span>One place for all of your child’s information without having to
					purchase multiple charts and planners!</span></h5>
					<h2>Try our Free Trial and see how much value it brings to your homeschool family.</h2>
					<a href="{{ route('register')}}">FREE 14 DAY TRIAL</a>
				</div>
			</div>
		</div>	
		<!-- tracking-area end -->		
		
	
		
		
		
		
		
		
		
		
		
		<!-- Main jQuery -->
		<script src="{{ asset('js/landing/jquery-3.4.1.min.js')}}"></script>

		<!-- Bootstrap Bundle jQuery -->
		<script src="{{ asset('js/landing/bootstrap.bundle.min.js')}}"></script>

		<!-- Fontawesome Script -->
		<script src="https://kit.fontawesome.com/7749c9f08a.js"></script>
		
		<!-- Custom jQuery -->
		<script src="{{ asset('js/landing/scripts.js')}}?{{time()}}"></script>
		
		<!-- Scroll-Top button -->
		<a href="#" class="scrolltotop"><i class="fas fa-angle-up"></i></a>
		
	</body>
</html>