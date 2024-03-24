<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Normal_event;
use App\Models\Diary;
use App\Models\My_event;
use App\Models\NormaleventUser;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
  // メイン画面を表示するために各テーブルデータを持ってくる
  //各タイトルと日付を持ってきたい
  public function index(Normal_event $normal_event,Diary $diary,My_event $my_event,NormaleventUser $normaleventuser)
  {
    $id = Auth::user()->id;
    
    $data_diary = $diary->where('users_id',$id)->get();
    $data_normal_events = $normal_event->get();
    $data_my_events = $my_event->where('users_id',$id)->get();
    
    //通常行事(normal_event)に現在の年を結合する
    $data_normal_events_vals = [];
    
    $data_normal_events_vals = collect($data_normal_events)->map(function ($data_normal_events) {
      //○○年の取得きっとあんまりよくない取り方
      $now = Carbon::now();
      $now_year = $now->year;
      //○○年を結合する
      $data_normal_events['start'] = $now_year."-".$data_normal_events->start;
        
      return $data_normal_events;
    });
    
    
    
    //個人行事(my_event)に現在の年を結合する
    $data_my_events_vals = [];
    
    $data_my_events_vals = collect($data_my_events)->map(function ($data_my_events) {
      //○○年の取得きっとあんまりよくない取り方
      $now = Carbon::now();
      $now_year = $now->year;
      //○○年を結合する
      $data_my_events['start'] = $now_year."-".$data_my_events->start;
      
      if($data_my_events->category == "birthday"){
      
      $data_my_events['title'] =$data_my_events->title."の誕生日";
        
      }elseif($data_my_events->category == "anniversary"){
      
      $data_my_events['title'] =$data_my_events->title."記念日";
        
      }else{
        Log::info("カレンダー通常行事のタイトル失敗");
      }
      
      return $data_my_events;
    });
      
    
    //dd($data_my_events_vals);
    //concatにて各テーブルの配列を結合する
    $data = $data_diary->concat($data_normal_events_vals)->concat($data_my_events_vals);
    //dd($data);
    return view('calendar.index')->with(['data'=> $data]);
  }
  
}
