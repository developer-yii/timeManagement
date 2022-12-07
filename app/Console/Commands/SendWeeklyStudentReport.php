<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\StudentTimeLog;
use App\User;
use App\Mail\SendWeeklyReportMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendWeeklyStudentReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:weeklyreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send weekly student report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = Carbon::now()->subDays(1)->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $end = Carbon::now()->subDays(1)->endOfWeek(Carbon::SUNDAY)->format('Y-m-d');
        
        $users = User::where('deleted_at',null)->get();
        foreach($users as $user)
        {            
            if($user->students)
            {                
                foreach($user->students as $student)
                {             
                    $data = [];    
                    $data['student'] = $student->first_name.' '.$student->last_name;   
                    $data['start'] = $start;
                    $data['end'] = $end;

                    $timelogs = StudentTimeLog::query()
                            ->join('students','students.id','=','student_time_log.student_id')
                            ->join('subjects','subjects.id','=','student_time_log.subject_id')
                            ->where('student_time_log.user_id',$user->id)
                            ->where('student_time_log.deleted_at',null)
                            ->where('student_time_log.student_id',$student->id)
                            ->where('log_date', '>=', $start)
                            ->where('log_date', '<=', $end)
                            ->select('student_time_log.id','subjects.subject_name','student_time_log.log_date','students.first_name','student_time_log.log_time')
                            ->get();

                    
                    $dataArray = [];                           
                    $day = Carbon::parse($start)->addDays(1)->format('Y-m-d');
                    $dayArray = [];                    
                    $dataArray[$start] = [];

                    while($day <= $end)
                    {
                        $dataArray[$day] = [];                        
                        $day = Carbon::parse($day)->addDays(1)->format('Y-m-d');
                    }                    

                    if(count($timelogs))
                    {                        
                        foreach($timelogs as $timelog)
                        {                            
                            if(!isset($dataArray[$timelog->log_date][$timelog->subject_name]))
                            {
                                $dataArray[$timelog->log_date][$timelog->subject_name] = 0;   
                            }

                            $dataArray[$timelog->log_date][$timelog->subject_name] = $dataArray[$timelog->log_date][$timelog->subject_name] + hhmmToSec($timelog->log_time);                            
                        }     

                    }   
                    $data['activities'] = $dataArray;

                    $pdf = \PDF::loadView('pdf.weekly-student-report', $data);
                    $to_email = $user->email;
                    Mail::to($to_email)->send(new SendWeeklyReportMail($pdf));

                }
            }            
        }        
        return 0;
    }
}
