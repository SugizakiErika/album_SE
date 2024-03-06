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
    return view('calendar.edit')->with([
      'normal_event' => $normal_event
      ]);
  }
  
  // 日付遷移後の詳細画面
  public function detail(Diary $diary,Diary_image $diary_image)
  {
    return view('calendar.detail')->with([
      //fullCalendarの日付
      
      'diary' => $diary,
      'diary_iamage' => $diary_image
      ]);
  }
  
  // 以下日付遷移後
  // 編集ボタンを押されたら編集できるようになる画面
  public function edit()
  {
    return view('Calendar.create');
  }
  //保存(登録)画面
  //後でバリデーション用のrequest作成する
  public function create(Request $request)
  {
    //$input = $request['diary'];
    //$diary->fill($input)->save();
    
    //$input_image = $request['diary_image'];
    //$diary_image->fill($input_image)->save();
    //return redirect('/calendar/edit/' . $user->id);
    $normal_event = new Normal_event();
    //$normal_event->start = $request->input(start); 
    //$normal_event->title = $request->input(title);
    
    $normal_event->start = '2024-03-03'; 
    $normal_event->title = 'ひな祭り';
    //$event->color = $request->color;


    $normal_event->save();
    return $normal_event;
  }
  
  //削除
 public function delete(Diary $diary,Diary_image $diary_image)
 {
   $diary->delete();
   $diary_image->delete();
   return redirect('/Calendar/edit/' . $user->id);
 }
}
