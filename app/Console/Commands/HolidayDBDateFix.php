<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Holiday;
use Carbon\Carbon;

class HolidayDBDateFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holidaydate:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command to fix holiday date from start,end to event date';

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
        $holidayObjs = Holiday::where('event_date',null)->get();        

        if($holidayObjs)
        {            
            foreach($holidayObjs as $key => $holiday)
            {   
                $day = Carbon::parse($holiday->start_date)->addDays(1)->format('Y-m-d');
                    
                    $newHoliday = Holiday::create([
                        'student_id' => $holiday->student_id,
                        'user_id' => $holiday->user_id,
                        'event_date' => $holiday->start_date,                        
                        'note' => $holiday->note,
                        'event_color' => $holiday->event_color,
                        'created_at' => $holiday->created_at,
                    ]);
                
                
                while($day <= $holiday->end_date)
                {                    
                    $newHoliday = Holiday::create([
                        'student_id' => $holiday->student_id,
                        'user_id' => $holiday->user_id,
                        'event_date' => $day,                        
                        'note' => $holiday->note,
                        'event_color' => $holiday->event_color,
                        'created_at' => $holiday->created_at,
                    ]);
                    
                    $day = Carbon::parse($day)->addDays(1)->format('Y-m-d');
                }               
                
            }
        }

        return 0;
    }
}
