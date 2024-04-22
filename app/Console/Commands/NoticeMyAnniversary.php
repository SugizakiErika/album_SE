<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailMyAnniversary;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\My_event;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class NoticeMyAnniversary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notice_my_event_anniversary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '個人行事の記念日の通知';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //今日の日付を取得する
        $data = Carbon::now(); //ex.03-20
        //$data_date = Carbon::now()->format('m-d');
        // $data_month = Carbon::now()->format('m');
        // $data_day = Carbon::now()->format('d');
        
        $my_events = MY_event::wherewhere('category','anniversary')->get();
        
        foreach($my_events as $my_event)
        {
            //日付調整
            $data = Carbon::now();
            $data_notice_later = $data->addDays($my_event->day)->format('m-d');
            
            //通知何日前
            if(MY_event::where('start',$data_notice_later)->where('category','anniversary')->exists())
            {
                $my_anniversaries = MY_event::where('start',$data_notice_later)->where('category','anniversary')->where('day',$my_event->day)->get();
                Log::info($my_anniversaries);        
            
                foreach($my_anniversaries as $my_anniversary)
                {
                    //各テーブルの取得
                    $user = User::find($my_anniversary->users_id);
            
                    $name = $user->name;
                    $email = $user->email;
                    $subject = "もうすぐ".json_encode($my_anniversary->title,JSON_UNESCAPED_UNICODE)."です！";
                    $comment = json_encode($my_anniversary->comment,JSON_UNESCAPED_UNICODE);
                    
                    Mail::send(new MailMyAnniversary($name,$email,$subject));
                }
            }else{
                //
            }
            
        }
    }
}
