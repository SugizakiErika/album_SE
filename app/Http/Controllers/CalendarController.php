<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Normal_event;
use App\Models\Diary;

class CalendarController extends Controller
{
  // メイン画面を表示するために各テーブルデータを持ってくる
  //各タイトルと日付を持ってきたい
  public function index(Normal_event $normal_event,Diary $diary)
  {
    $data = $diary->get();
    //$data_diary = $diary->get();
    //$data_normal_event = $normal_event->get();
    
    //concatにて各テーブルの配列を結合する
    //$data = $data_diary->concat($data_normal_event);
    return view('calendar.index')->with(['data'=> $data]);
  }
  
  public function send(Request $request)
  {
    return view('calendar.create')->with($request);
  }
}
