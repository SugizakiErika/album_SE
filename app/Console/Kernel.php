<?php


    //crontab -eで編集,-lでリスト確認,-rで削除
    //* * * * * cd /home/ec2-user/environment/album && php artisan schedule:run >> /dev/null 2>&1

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;
use App\Console\Commands\NoticeMails;
use App\Console\Commands\NoticeMyAnniversary;
use App\Console\Commands\NoticeMyBirthday;
use App\Console\Commands\NoticeMyothers;

use App\Models\Normal_event;
use App\Models\My_event;
use App\Models\User;
use App\Models\NormaleventUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        
        NoticeMails::class,
        NoticeMyAnniversary::class,
        NoticeMyBirthday::class,
        NoticeMyothers::class,
        
        ];
    
    
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //今日の日付を取得する
        $data = Carbon::now(); //ex.03-20
        $data_date = Carbon::now()->format('m-d');
        $data_month = Carbon::now()->format('m');
        $data_day = Carbon::now()->format('d');
        
        $normalevent_users = NormaleventUser::all();
        
         
        //通常行事で今日当てはまるものがあれば実行する
        foreach($normalevent_users as $normalevent_user)
        {
            //日付の調整
            $data_notice_later = $data->addDays((int)$normalevent_user->day)->format('m-d');
            
            $normal_event = Normal_event::find($normalevent_user->normal_event_id);
        
        if($normal_event->start == $data_notice_later)
        {
            $schedule->command('command:notice_normal_event')
            ->yearlyOn($data_month,$data_notice_ago,'06:00');
            //->everyMinute();
            }else{
                    Log::info('失敗kernel');
            }
        }
        
        if(MY_event::where('start',$data)->where('category','birthday')){
            
             $schedule->command('command:notice_my_event_birthday')->yearly($data,'6:00');
    
        }else{
            //何もしない
        }
        
        if(MY_event::where('start',$data)->where('category','anniversary')){
            
            $schedule->command('command:notice_my_event_anniversary')->yearly($data,'6:00');
            
        }else{
             //何もしない
        }
        
        // if($data_my_events->start == $data && $data_my_events['category'] == 'others'){
            
        //     $schedule->command('command:notice_my_event_others')->yearly($data,'6:00');
            
        // }else{
        //     //何もしない
        // }
        
        
        
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
