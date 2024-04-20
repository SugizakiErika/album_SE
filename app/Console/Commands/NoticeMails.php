<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNormal;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Normal_event;
use App\Models\NormaleventUser;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class NoticeMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notice_normal_event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '通常行事の通知';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //今日の日付を取得する
        $data = Carbon::now(); //ex.03-20
        // $data_date = Carbon::now()->format('m-d');
        // $data_month = Carbon::now()->format('m');
        // $data_day = Carbon::now()->format('d');
        
        $normalevent_users = NormaleventUser::where('notice','1')->get();
        
         
        //通常行事で今日当てはまるものがあれば実行する
        foreach($normalevent_users as $normalevent_user)
        {
            $data = Carbon::now();
            //日付の調整
            $data_notice_later = $data->addDays($normalevent_user->day_num)->format('m-d');
            
            //各テーブルの取得
            $user = User::find($normalevent_user->user_id);
            $normal_event = Normal_event::find($normalevent_user->normal_event_id);
        
            if($normal_event->start == $data_notice_later)
            {
                //Log::info("成功");
                $name = $user->name;
                $email = $user->email;
                $subject = "もうすぐ".json_encode($normal_event->title,JSON_UNESCAPED_UNICODE)."です！";
                $explanation = json_encode($normal_event->explanation,JSON_UNESCAPED_UNICODE);
                $todo = json_encode($normal_event->todo,JSON_UNESCAPED_UNICODE);
        
                Mail::send(new MailNormal($name,$email,$subject,$explanation,$todo));
         
            }else{
                Log::info("失敗");
            }
        }
    }
}
