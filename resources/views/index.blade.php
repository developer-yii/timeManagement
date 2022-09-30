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
		<link rel="stylesheet" href="{{ asset('css/landing/style.css')}}" />	
		
		<!-- Responsive CSS -->
		<link rel="stylesheet" href="{{ asset('css/landing/responsive.css')}}" />	
		
	</head>
	<body>

		<!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

		<!-- header-area start -->	
		<header class="header-area">
			<div class="container">
				<div class="header-item">
					<nav class="navbar navbar-expand-md">				    
						<a href="#" class="navbar-brand"><img src="{{ asset('images/landing/logo.png')}}" alt="" /></a>
						<div class="navbar-toggler hamburger hamburger--springr" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						    <div class="hamburger-box">
						    	<div class="hamburger-inner"></div>
						    </div>
						</div>
					    <div class="collapse navbar-collapse" id="navbarNav">
					      <ul class="navbar-nav">
						      	<li class="nav-item">
						        	<a class="nav-link" href="#">Home</a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link" href="#">Price</a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link" href="#">FAQ</a>
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
		<div class="planner-area">
			<div class="planner-item">
				<img src="{{ asset('images/landing/01.png')}}" alt="" />
			</div>
			<div class="planner-area-inner">
				<div class="container">
					<div class="planner-item2">
						<h2><p>An online homeschool planner </p><p>that will give you more time for the <span>fun</span> things in life.</p></h2>
						<ul class="ml-9">
							<li><img src="{{ asset('images/landing/02.png')}}" alt="" />A planner that you can use for the whole family.</li>
							<li><img src="{{ asset('images/landing/02.png')}}" alt="" />Calculates ongoing hours & attendance, so you don’t have to.</li>
							<li><img src="{{ asset('images/landing/02.png')}}" alt="" />Dashboard with graphs to quickly see your child’s progress.</li>
							<li><img src="{{ asset('images/landing/02.png')}}" alt="" />Super easy to use and available on your phone, tablet or PC!</li>
						</ul>
						<a href="{{ route('register') }}">FREE 14 DAY TRIAL</a>
					</div>
				</div>
			</div>
		</div>		
		<!-- planner-area end -->

		<!-- tracking-area start -->	
		<div class="tracking-area">
			<div class="container">
				<div class="tracking-item">
					<h2>Our planner takes minutes to use <br> and will save you hours on tracking<br> state requirements and your busy schedule.</h2>
					<ul>
						<li><span><img src="{{ asset('images/landing/03.png')}}" alt="" /></span>Plan it.</li>
						<li><span><img src="{{ asset('images/landing/04.png')}}" alt="" /></span>Track it.</li>
						<li><span><img src="{{ asset('images/landing/05.png')}}" alt="" /></span>Finished!</li>
					</ul>
					<p>You can create, modify and save the time <br>for each student or family member.</p>
					<img src="{{ asset('images/landing/06.png')}}" alt="" />
					<p>Life changes...sometimes by the minute. <br>You can simply add or change events, appointments, <br>days off and more with a few clicks!</p>
					<img src="{{ asset('images/landing/07.png')}}" alt="" />
					<p>The dashboard features all of your stats and graphs to <br>quickly see: </p>
					<h4>* The hours accrued and remaining for each child.</h4>
					<h4>* Their attendance accrued and remaining.</h4>
					<h4>* Core vs Non-core hours.</h4>
					<h4>* We even breakdown each subject so you can make <br>sure your child is getting a well rounded education.</h4>
					<a href="#">FREE 14 DAY TRIAL</a>
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
		<script src="{{ asset('js/landing/scripts.js')}}"></script>
		
		<!-- Scroll-Top button -->
		<a href="#" class="scrolltotop"><i class="fas fa-angle-up"></i></a>
		
	</body>
</html>