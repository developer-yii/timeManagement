<!doctype html>
<html lang="en">
  <head>
    <title>Welcome to your Homeschool Minutes Planner Trial</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-12 m-auto">
                <p>Dear {{ucfirst($data['username'])}},</p>
                <!-- <br/> -->
                <p>Congratulations on your decision to try Homeschool Minutes Planner!</p>
                <p>Our goal is to help parents keep track of important state requirements and schedules.  Even if your state doesn’t have specific requirements for attendance/hours our planner will still help you keep track of schedules, appointments, and subjects to make sure you’re offering a balanced education.</p>
                <br/>
                <h3>Quick Start Links & Information:</h3>
                <p style="font-size: 18px;">Login link to your Homeschool Minutes Planner.</p>
                <h3><a href="{{$data['loginRoute']}}">Login</a></h3>                
                <!-- <br/> -->
                <h4 class="fw-bold">Step 1: Create your student/parent profile</h4>
                <p>Click the "Add Names/Student" button at the top.</p>
                <p>Fill in the student or name you want to be able to use for the planner.</p>
                <p>**If you are entering a name that will not be tracked but would like to be able to use the planner portion (Mom or Dad etc.) you can enter 0 for attendance and hours required.</p>

                <br/>
                <h4 class="fw-bold">Step 2: Add Subjects/Activities</h4>
                <p>Click the "Add Subjects/Activities" button at the top.</p>
                <p>Enter all non-core and core subjects or activities you will be tracking. (example: Drums, Math, Church, Dance, Reading)</p>

                <br/>
                <h4 class="fw-bold">Step 3: You are ready to start scheduling your events, activities, and school subjects!</h4>
                <p>Add Student Time/Activity Button - This is for adding hours and attendance that you would like to be tracked in your "Progress Reports" dashboard.</p>
                <p>Add Holiday/Events Button - This is for adding Holidays, Events, Playdates, Doctor's Appointments, and more!</p>

                <br/>

                <p>If you need help getting started or have questions, please contact us!</p>                

                <br/>

                <p> Kind regards,</p>
                <p> Amber and the Homeschool Minutes Team </p>
            </div>
        </div>
    </div>
  </body>
</html>