<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Normal_event;
use Carbon\Carbon;
use DateTime;

class NormalEventDayUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:normal_event_day_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '1月1日の0：00に通常行事の日付の中で毎年変わるものを変更する';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //年を取得する
        $now = Carbon::now();
        $now_year = now()->year;
         /**
        * 日付を取得する関数
        * 
        * @param int $year 西暦
        * @param int $month 月
        * @param String $dayOfWeek 曜日('Sun','Mon','Tue','Wed','Thu','Fri','Sat')
        * @param int $week 週番号
        * 
        * @return int 日にち
        */
        function getDay($year,$month,$dayOfWeek,$week)
        {
            //月初めの日付を取得
            $date = new DateTime("{$year}-{$month}-01");
         
            //月の初めが指定した曜日になるまで進める
            while($date->format('D')!==$dayOfWeek){
                $date->modify('+1 day');
            }
            
            //指定した週番号になるまで進める
            for($i=1; $i<$week; $i++){
                $date->modify('+7 days');
            }
            
            //指定した月を超えた場合はエラー
            if((int)$date->format('m')!==$month){
                //その月に存在しない日付を指定した時
                return -1; 
            }
            
            return $date->format('m-d');
        }
        
        //成人式
        $normal_event = Normal_event::find(6);
        $normal_event->start = getDay($now_year,1,'Mon',2);
        $normal_event->f_end = getDay($now_year,1,'Mon',2);
        $normal_event->save();
        
        //母の日
        $normal_event = Normal_event::find(18);
        $normal_event->start = getDay($now_year,5,'Sun',2);
        $normal_event->f_end = getDay($now_year,5,'Sun',2);
        $normal_event->save();
        
        //父の日
        $normal_event = Normal_event::find(19);
        $normal_event->start = getDay($now_year,6,'Sun',3);
        $normal_event->f_end = getDay($now_year,6,'Sun',3);
        $normal_event->save();
        
        //敬老の日
        $normal_event = Normal_event::find(26);
        $normal_event->start = getDay($now_year,9,'Mon',3);
        $normal_event->f_end = getDay($now_year,9,'Mon',3);
        $normal_event->save();
        
    }
}
