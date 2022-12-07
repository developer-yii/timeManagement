<!doctype html>
<html lang="en">
   <head>
      <title>Homeschool Minutes Weekly Report</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.typekit.net/qyy7cvc.css">
      <style>
         td, {
            padding: 3px;
            margin: 2px;
            padding-right: 15px;
            font-size: 16px;
         }    

         body,*,html {
            font-family: nunito, sans-serif;
         }     

         table{
            padding-bottom: 15px;
         }
      </style>
   </head>
   <body>
      <?php
         $startDt = date_create($start);
         $startDt = date_format($startDt,"F jS, Y");

         $endDt = date_create($end);
         $endDt = date_format($endDt,"F jS, Y");
      ?>
      <div class="container">
         <div class="row">
            <div style="align-content: center; text-align: center; align-items: middle;">
               <h5>Homeschool Minutes Weekly Report for {{ucfirst($student)}}</h5>
            </div>
            <h6 style="align-content: center; text-align: center; align-items: middle;">{{$startDt}} thru {{ $endDt }}</h6>
            <p style="align-content: center; color: white;background: #09d4ea; padding: 2px; font-weight: 600; margin: 5px;">Weekly Activity Log</p>

            <div class="col-xl-6 col-lg-6 col-sm-12 m-auto">
               @php
                  $weeklyTotal = 0;
               @endphp
               @foreach($activities as $key => $subs)               
                  @if(empty($subs))
                     <table>
                        <thead>
                           <tr style="font-weight: 600;">
                              <th style="text-decoration: underline">{{ pdfTableDate($key)}}</th>                              
                           </tr>
                        </thead>
                        <tbody>                        
                           <tr>
                              <td style="background: lightgrey;">No Activity</td>                           
                           </tr>
                           
                        </tbody>
                     </table>
                  @else
                     <table>
                        <thead>
                           <tr style="font-weight: 600;">
                              <th colspan="3" style="text-decoration: underline">{{ pdfTableDate($key)}}</th>                              
                           </tr>
                        </thead>
                        <tbody>
                           @php
                              $dailyTotal = 0;
                           @endphp
                           @foreach ($subs as $k => $sub)
                              @php
                                 $dailyTotal = $dailyTotal + $sub;
                              @endphp
                           <tr>
                              <td>{{$k}}</td>
                              <td>{{secToHHPart($sub)}} hours</td>
                              <td>{{secTOmmPart($sub)}} minutes</td>
                           </tr>
                           @endforeach
                           @php
                              $weeklyTotal = $weeklyTotal + $dailyTotal;
                           @endphp
                           <tr style="background: lightgrey;">
                              <td>Daily Total</td>
                              <td>{{secToHHPart($dailyTotal)}} hours</td>
                              <td>{{secTOmmPart($dailyTotal)}} minutes</td>
                           </tr>
                        </tbody>
                     </table>
                  @endif                  
               @endforeach
               <table>
                  <thead>
                     <tr style="font-weight: 600;">
                        <td>Weekly Total</th>
                        <td>{{secToHHPart($weeklyTotal)}} hours</td>
                        <td>{{secTOmmPart($weeklyTotal)}} minutes</td>
                     </tr>
                  </thead>                  
               </table>
            </div>
         </div>
      </div>
   </body>
</html>