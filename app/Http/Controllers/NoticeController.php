<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    // 個人通知一覧画面
    public function myindex()
    {
      return view('notice.myindex');
    }
    
    // 個人通知登録完了画面
    public function mycomplete()
    {
      return view('notice.mycomplete');
    }
  
    // 個人通知登録画面
    public function mycreate()
    {
      return view('notice.mycreate');
    }
  
    // 個人通知編集画面
    public function myedit()
    {
      return view('notice.myedit');
    }
  
    // 通常通知一覧画面
    public function normalindex()
    {
      return view('notice.myindex');
    }
  
    // 通常通知登録完了画面
    public function normalcomplete()
    {
      return view('notice.normalcomplete');
    }
  
    // 通常通知登録画面
    public function normalcreate()
    {
      return view('notice.normalcreate');
    }
  
    // 通常通知編集画面
    public function normaledit()
    {
      return view('notice.normaledit');
    }
  
}
