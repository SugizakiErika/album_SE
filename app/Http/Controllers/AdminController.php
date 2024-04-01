<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMail;

use App\Models\User;
use App\Models\Diary_image;
use App\Models\Diary;

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
     //目次
    public function index()
    {
        return view('admin.index');
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

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function d_update(DiaryRequest $request,Diary $diary,Diary_image $diary_image)
    // {
    //     //title,date,comment,color,users_idの保存
    //     $input = $request['diary'];
    //     $diary->start = $input["start"];
    //     $diary->f_end = $input["start"];
    //     $diary->title = $input["title"];
    //     $diary->comment = $input["comment"];
    //     $diary->deleted_at = $input["deleted_at"];
    //     $diary->color = "#FFCCFF";
    //     $diary->url = '/show/' .$diary->id;
    //     $diary->users_id = $input['id'];
    //     $diary->save();
        
    //     //画像の更新をする場合は一度削除してから更新する
    //     if($request->hasFile('files'))
    //     {
    //         //削除処理
    //         $diary_image->where('diaries_id',$diary->id)->delete();
    //         //更新処理
    //         $files = $request->file('files');
    //         foreach($files as $file){
    //             //ファイル名の取得
    //             $file_name = $file->getClientOriginalName();
    //             //ファイルの保存
    //             $file->storeAS('public/',$file_name);
    //             //DBへのファイル名とパスの保存
    //             $diary_image = new Diary_image();
    //             $diary_image->path = 'storage/' .$file_name;
    //             $diary_image->name = $file_name;
    //             $diary_image->diaries_id = $diary->id;
    //             $diary_image->save();
    //         }
    //     }else{
    //         //何もしない
    //         }
    //     return redirect()->route('admin.d_show');
    // }

    //削除
    public function d_delete(Diary $diary)
  {
       $diary->delete();
       
       return redirect()->route('admin.d_show');
   }
}
