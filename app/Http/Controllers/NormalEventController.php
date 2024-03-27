<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Normal_event;
use App\Models\User;
use App\Models\NormaleventUser;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class NormalEventController extends Controller
{
    //通常行事の毎年日付が変わるものを変更する
    public function index()
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
        
        return redirect()->route('create.normalevent');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Normal_event $normal_event)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('normal_event.edit')->with(['users' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request["n_event"];
        //dd($input);
        
        $id = Auth::user()->id;
        $user = User::find($id);
        //$user->normal_events()->syncWithPivotValues(1,['notice'=>1,'day_num'=>8],false);
        $user->normal_events()->syncWithPivotValues($input["id"],['notice'=>$input["notice"],'day_num'=>$input["day_num"]],false);
        
        //$normal_event->url = '/myevent/edit/' .$my_event->id;
        
        
        return redirect()->route('create.normalevent', ['id' => 1]);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
     public function show(Normal_event $normal_event)
     {
         return view('normal_event.show')->with(['normal_event' => $normal_event]);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $result = $request->all();
        
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->normal_events()
             ->syncWithPivotValues($result["ajax_input_id"],
                                  ['notice'=>$result["ajax_input_notice"],
                                  'day_num'=>$result["ajax_input_day_num"]],false);
                                  
        return $result;
    }
}
