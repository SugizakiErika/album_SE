<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Normal_event;
use App\Models\Diary;
use App\Models\My_event;
use Carbon\Carbon;

class CalendarController extends Controller
{
  // メイン画面を表示するために各テーブルデータを持ってくる
  //各タイトルと日付を持ってきたい
  public function index(Normal_event $normal_event,Diary $diary,My_event $my_event)
  {
    $data_diary = $diary->get();
    $data_normal_events = $normal_event->get();
    $data_my_events = $my_event->get();
    
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
      
      return $data_my_events;
    });
      
    
    //dd($data_my_events_vals);
    //concatにて各テーブルの配列を結合する
    $data = $data_diary->concat($data_normal_events_vals)->concat($data_my_events_vals);
    //dd($data);
    return view('calendar.index')->with(['data'=> $data]);
  }
  
}
