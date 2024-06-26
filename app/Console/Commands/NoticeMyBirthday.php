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

class NoticeMyBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notice_my_event_birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '個人行事の誕生日の通知';

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
        
        $my_events = MY_event::where('category','birthday')->get();
        
        foreach($my_events as $my_event)
        {
            //日付調整
            $data = Carbon::now();
            $data_notice_later = $data->addDays((int)$my_event->day)->format('m-d');
            Log::info("誕生日当日日付：".$data_notice_later);
            //通知何日前
            if(MY_event::where('start',$data_notice_later)->where('category','birthday')->exists())
            {
                $my_birthdays = MY_event::where('start',$data_notice_later)->where('category','birthday')->where('day',$my_event->day)->get();
                Log::info($my_birthdays);     
            
                foreach($my_birthdays as $my_birthday){
                
                //各テーブルの取得
                $user = User::find($my_birthday->users_id);
            
                $name = $user->name;
                $email = $user->email;
                $subject = "もうすぐ".json_encode($my_birthday->title,JSON_UNESCAPED_UNICODE)."です！";
                $comment = json_encode($my_birthday->comment,JSON_UNESCAPED_UNICODE);
            
                Mail::send(new MailMyAnniversary($name,$email,$subject));
                }
            }else{
                //
            }
        }
    }
}
