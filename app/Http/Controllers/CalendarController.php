<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Normal_event;

class CalendarController extends Controller
{
  // メイン画面を表示するために各テーブルデータを持ってくる
  //各タイトルと日付を持ってきたい
  public function index(Normal_event $normal_event)
  {
    //dd($normal_event->get());
    $data = $normal_event->get();
    return view('calendar.index')->with(['data'=> $data]);
    //return view('calendar.index');
  }
  public function send(Request $request)
  {
    return view('calendar.create')->with($request);
  }
}
