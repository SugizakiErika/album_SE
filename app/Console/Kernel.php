<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\Console\Commands\NoticeMails;

use App\Models\Normal_event;
use App\Models\My_event;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        
        NoticeMails::class,
        
        
        ];
    
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        $data_normal_events = Normal_event::where('start')->get();
        $data_my_events = My_event::where('start')->get();
        
        $data = Carbon::now()->toDateString(); //ex.2024-03-20
        $now_year = $now->year; //ex.2024
        
        $data_normal_events = $now_year."-".$data_normal_events->start;
        $data_my_events = $now_year."-".$data_my_events->start;
        
        //お試し用:後で消す
        $schedule->command('command:notice_normal_event')->everyMinute();
        
        if($data_normal_events == $data)
        {
            $schedule->command('command:notice_normal_event')->everyMinute();

        }else{
            //何もしない
        }
        
        if($data_my_events == $data && $data_my_events['category'] == 'birthday'){
            
            $schedule->command('command:notice_my_event_birthday')->yearly($data,'6:00');
    
        }else{
            //何もしない
        }
        
        if($data_my_events == $data && $data_my_events['category'] == 'anniversary'){
            
            $schedule->command('command:notice_my_event_anniversary')->yearly($data,'6:00');
            
        }else{
            //何もしない
        }
        
        if($data_my_events == $data && $data_my_events['category'] == 'others'){
            
            $schedule->command('command:notice_my_event_others')->yearly($data,'6:00');
            
        }else{
            //何もしない
        }
        
        
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
