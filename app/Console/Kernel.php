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
        //$data_date = Carbon::now()->format('m-d');
        //$data_month = Carbon::now()->format('m');
        //$data_day = Carbon::now()->format('d');
        
        $normalevent_users = NormaleventUser::where('notice','1');
        $my_events = MY_event::all();
         
         //1月1日の0：00に通常行事の日付の中で毎年変わるものを変更する
         $schedule->command('command:normal_event_day_update')->yearlyOn(1,1,'00:00');
         
         
        //通常行事で今日当てはまるものがあれば実行する
        foreach($normalevent_users as $normalevent_user)
        {
            //通知用日付の調整
            $data_notice_later = $data->addDays((int)$normalevent_user->day)->format('m-d');
            
            $normal_event = Normal_event::find($normalevent_user->normal_event_id);
            
            //通知日付何日前のお知らせ
            if($normal_event->start == $data_notice_later)
            {
                $schedule->command('command:notice_normal_event')
                ->dailyAt('06:00');
                //->yearlyOn($data_month,$data_notice_later,'06:00');
                //->everyMinute();
            }else{
                    Log::info('失敗：通常行事の通知何日前メール送信');
            }
        }
        
        foreach($my_events as $my_event)
        {
            //日付調整
            $data_notice_later = $data->addDays((int)$my_event->day)->format('m-d');
            
            
            if(MY_event::where('start',$data_notice_later)->where('category','anniversary')->exists())
            {
                Log::info("成功：何日前anniversary");
                $schedule->command('command:notice_my_event_anniversary')->dailyAt('06:00');
             
            }else{
                //何もしない
            }
            
            if(MY_event::where('start',$data_notice_later)->where('category','birthday')->exists())
            {
                Log::info("成功：何日前birthday");
                $schedule->command('command:notice_my_event_birthday')->dailyAt('06:00');
        
            }else{
                //何もしない
            }
            
            if(MY_event::where('start',$data_notice_later)->where('category','others')->exists())
            {
                Log::info("成功：何日前others");
                $schedule->command('command:notice_my_event_others')->dailyAt('06:00');
            }else{
                //何もしない
            }
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
