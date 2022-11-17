@extends('layouts.app')

@section('content')
<div class="content">
	<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Help/Quick Tips</li>
                    </ol>
                </div>
                <h4 class="page-title">Help/Quick Tips</h4>
            </div>
        </div>
    </div>
    <div class="row">
	    <div class="col-12">
	        <div class="card">
	            <div class="card-body">
	            	<p>For required hours, subjects, or attendance you can visit HSLDA at HSLDA.org</p>
	            	<p>For area homeschool classifieds, activities, groups, and more visit <a href="https://Homeschoolnextdoor.com" target="_blank">Homeschoolnextdoor.com</a></p>
	            	<hr>
	            	<p><h5>Monthly Planner</h5></p>

	            	<ul>
		            	<li>Add Names/Students – enter all the family members you would like to add to the planner
						(Mom or Dad, you can enter your name too!  Just put 0's in for attendance and hours required.)</li>
						<li>Add Subjects – add all the subjects or activities you would like to track.</li>
						<li>Add Holidays/Events - remember this is just to keep track of your schedule and will not calculate hours.</li>
						<li>Add Student Time/Activity – Add all hours that you would like to calculate and show on the Progress Charts.  Upload photos of work and links for each entry.</li>
						<li>** If you would like to see more detail visit our Help/Quick Tips page on the main menu.</li>
					</ul>

					<hr>

					<p><h5>Progress Charts</h5></p>

	            	<ul>
		            	<li>See all your stats quickly for each child or family member.</li>
						<li>This page will automatically keep track of hours, attendance, and the amount of time you spend on certain subjects.</li>
						<li>This is the perfect tool to help make sure you are getting all your state requirements in or just to have peace of mind that your chosen curriculum is giving your child everything they need.</li>
						<li>** You will be amazed at how much time you invest into homeschooling that you may not account for when estimating or recalling your times.</li>						
					</ul>
					
					<hr>

					<p><h5>Names/Students List</h5></p>

	            	<ul>
		            	<li>This will give you a complete list of all the students you have entered in the Monthly Planner Calendar.</li>
						<li>Names can be color coded.</li>
						<li>** Enter Mom or Dad in the list to keep track of daily appointments, workouts, and even dinner!</li>												
					</ul>
					
					<hr>

					<p><h5>Subject/Activity</h5></p>

	            	<ul>
		            	<li>Welcome to Homeschool Minutes Subject/Activity List!</li>
						<li>This will give you a complete list of all the subjects/activities you have entered in the Monthly Planner.</li>
						<li>** Anything that will be tracked through either core or non-core hours when entering time spent. Example: Drums, History, Dance Class, Spanish….</li>												
					</ul>
					
					<hr>

					<p><h5>Holiday/Events List</h5></p>

	            	<ul>
		            	<li>This will give you a complete list of all the holiday/events you have entered in the Monthly Planner.</li>
						<li>Events can be color coded.</li>
						<li>** These items are not calculated in your hours.</li>
						<li><h6>You can have two options:</h6>
						<p>1. TWO ENTRIES. You can add an event (Drums 12:30-1:00 pm), then add student time/activity of 30 minutes in drums.  Since you can color code the events it helps it stand out from the rest as a reminder.</p>
						<p>2. ONE ENTRY. The Second option is to add the drum Lesson through the Add Student Time/Activity button on your planner only. </p></li>
					</ul>
					
					<hr>

					<p><h5>Monthly Student Log</h5></p>

	            	<ul>
		            	<li>Quickly see your hours and attendance by day, subject, and month.</li>
						<li>** This is a great page to print out each week or month if you would like to keep an extra paper record.</li>																	
					</ul>
					
					
	            </div>
	        </div>
	    </div>
	</div>
    <!-- end page title --> 

</div>
@endsection