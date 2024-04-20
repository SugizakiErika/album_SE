<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Normal_event;
use App\Models\Diary;
use App\Models\My_event;
use App\Models\NormaleventUser;
use App\Models\Release_list;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
  // メイン画面を表示するために各テーブルデータを持ってくる
  //各タイトルと日付を持ってきたい
  public function index(Normal_event $normal_event,Diary $diary,My_event $my_event,NormaleventUser $normaleventuser,Release_List $release_list)
  {
    $id = Auth::user()->id;
    
    $data_diary = $diary->where('users_id',$id)->get();
    $data_normal_events = $normal_event->get();
    $data_my_events = $my_event->where('users_id',$id)->get();
    
    //フォロワー?に日記が見れるようにする
    $data_diary_follows = [];
    $data_diary_follows_vals = [];
    //フォローテーブルの中の
    $data_release_follows = $release_list->where('users_id',$id)->where('notice',1)->get();
    
    foreach($data_release_follows as $data_release_follow)
    {
      $data_diary_follows = Diary::where('users_id',$data_release_follow->release_user_id)->get();
    }
    
      $data_diary_follows_vals = collect($data_diary_follows)->map(function ($data_diary_follows){
      
      $data_diary_follows['color'] = Release_list::where('users_id',Auth::user()->id)->value('select_color');
      $data_diary_follows['url'] = '/show_follow/' .$data_diary_follows->id;
        
      return $data_diary_follows;
      
    });
    
    
    //通常行事(normal_event)に現在の年を結合する
    $data_normal_events_vals = [];
    
    //個人行事(my_event)に現在の年を結合する
    $data_my_events_vals = [];
    
    $data_normal_events_vals = collect($data_normal_events)->map(function ($data_normal_events) {
      //○○年の取得きっとあんまりよくない取り方
      $now = Carbon::now();
      $now_year = $now->year;
      //○○年を結合する
      $data_normal_events['start'] = $now_year."-".$data_normal_events->start;
      
      $data_normal_events['f_end'] = $now_year."-".$data_normal_events->f_end;
      return $data_normal_events;
    });
    
    $data_my_events_vals = collect($data_my_events)->map(function ($data_my_events) {
      //○○年の取得きっとあんまりよくない取り方
      $now = Carbon::now();
      $now_year = $now->year;
      //○○年を結合する
      $data_my_events['start'] = $now_year."-".$data_my_events->start;
      $data_my_events['f_end'] = $now_year."-".$data_my_events->f_end;
      
      if($data_my_events->category == "birthday"){
      
      $data_my_events['title'] =$data_my_events->title."の誕生日";
        
      }elseif($data_my_events->category == "anniversary"){
      
      $data_my_events['title'] =$data_my_events->title."記念日";
        
      }else{
        Log::info("カレンダー通常行事のタイトル失敗");
      }
      
      return $data_my_events;
    });
      
    
    //concatにて各テーブルの配列を結合する
    $data = $data_diary->concat($data_normal_events)->concat($data_my_events_vals)->concat($data_diary_follows_vals);
    
    return view('calendar.index')->with(['data'=> $data])->with(['data_release_follows' => $data_release_follows]);
  }
  
  //フォローカラー変更
  public function create(Request $request)
  {
    $input = $request['release'];
    $release_list = Release_List::find($input["follow_id"]);
    $release_list->select_color  = $input["select_color"];
    $release_list->save();
    return redirect()->route('calendar');
  }
}
