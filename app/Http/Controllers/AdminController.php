<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMail;

use App\Models\User;
use App\Models\Diary_image;
use App\Models\Diary;
use App\Models\Inquiry_list;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\AdminMailRequest;
use App\Http\Requests\DiaryRequest;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //問い合わせ一覧
    public function index(Inquiry_list $inquiry_list)
    {
        //dd($inquiry_list->get());
        return view('admin.index')->with(['inquiry_lists' => $inquiry_list->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     //メール送信画面
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //メール送信実行
    public function store(AdminMailRequest $request)
    {
        $input = $request['admin'];
        
        $title = $input["title"];
        $comment = $input["comment"];
        
        $email = User::get(['email']);
        
        Mail::send(new AdminMail($title,$email,$comment));
         return view('admin.send_fin')->with(['title' => $title])->with(['comment' => $comment]);
    }
    
     //日記削除取り消し画面
    public function d_show()
    {
        //$diary = Diary::with(['diary_images'])->get();
        //withTrashed:これだと削除以外も取得できる
        $diary = Diary::with(['diary_images'])->withTrashed()->get();
        
        //dd($diary);
        return view('admin.d_show')->with(['diary' => $diary]);
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //削除取り消し
    public function d_edit(Request $request)
    {
        $input = $request['diary'];
        Diary::onlyTrashed()->where('id',$input)->restore();
        return redirect()->route('admin.d_show');
    }

    //削除
    public function d_delete(Diary $diary)
  {
       $diary->delete();
       
       return redirect()->route('admin.d_show');
   }
}
