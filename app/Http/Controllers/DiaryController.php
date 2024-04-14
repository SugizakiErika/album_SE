<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DiaryRequest;
use App\Models\Diary_image;
use App\Models\Diary;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
//use Session;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DiaryController extends Controller
{
    //ajax通信用：日記の画像確認
    public function a_create()
    {
        
    }
    public function a_store(Request $request)
    {
        $file_path = [];
        //Log::info($request->file('files'));
        // $files = json_decode($request['files']);
        //Log::info($files);
         if($request->has('files')) {
         foreach($request->file('files') as $file){
            //ファイル名の取得
            $file_name = $file->getClientOriginalName();
            //Log::info($file_name);
            //ファイルの保存
            $file->storeAS('public/',$file_name);
            // セッションへのファイル名とパスの保存用に配列に入れる
            array_push($file_path, 'storage/' .$file_name);
            // $diary_image = new Diary_image();
            // $diary_image->path = 'storage/' .$file_name;
            // $diary_image->name = $file_name;
            // $diary_image->diaries_id = $diary->id;
            // $diary_image->save();
         }
         $result = "upload_fin";
         }else{
             Log::info("ファイルがありません");
         }
         
        $result = $file_path;
            //Session::put('file_name', $file_name);
        return $result;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Diary_image $diary_image,Request $request)
    {
        $date = $request->input('date');
        
        return view('diary.create')->with(['date' => $date]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //日記の登録
    public function store(Diary $diary,Diary_image $diary_image,DiaryRequest $request)
    {
        //title,date,comment,color,users_idの保存
        
        $input = $request['diary'];
        $diary->start = $input["start"];
        $diary->f_end = $input["start"];
        $diary->title = $input["title"];
        $diary->comment = $input["comment"];
        $diary->color = "#FFCCFF";
        $diary->url = '/show/' .$diary->id;
        $diary->users_id = Auth::user()->id;
        $diary->save();
        $diary->url = '/show/' .$diary->id;
        $diary->save();
        
        $day_now = Carbon::now();
        //$imagefiles = $request->file('files');
        //dd($request->file('files'));
        if($request->has('files')) {
        foreach($request->file('files') as $file){
            //ファイル名の取得
            //dd($file);
            $file_name = $file->getClientOriginalName();
            //Log::info($file_name);
            $file_random = Str::random(15);
            //ファイルの保存
            $file->storeAS('public/',$day_now.$file_random.'_'.$file_name);
            //DBへのファイル名とパスの保存
            $diary_image = new Diary_image();
            $diary_image->path = 'storage/' .$day_now.$file_random.'_'.$file_name;
            $diary_image->name = $file_name;
            $diary_image->diaries_id = $diary->id;
            $diary_image->save();
        }
        }
        return redirect()->route('show.diary', ['diary' => $diary->id]);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Diary $diary)
    {
        $this->authorize('view', $diary);
        
        return view('diary.show')->with(['diary' => $diary]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Diary $diary)
    {
        $this->authorize('view', $diary);
        
        return view('diary.edit')->with(['diary' => $diary]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiaryRequest $request,Diary $diary,Diary_image $diary_image)
    {
        //title,date,comment,color,users_idの保存
        $input = $request['diary'];
        $diary->start = $input["start"];
        $diary->f_end = $input["start"];
        $diary->title = $input["title"];
        $diary->comment = $input["comment"];
        $diary->color = "#FFCCFF";
        $diary->url = '/show/' .$diary->id;
        $diary->users_id = Auth::user()->id;
        $diary->save();
        
        $day_now = Carbon::now();
        
        //画像の更新をする場合は一度削除してから更新する
        if($request->hasFile('files'))
        {
            //削除処理
            $diary_image->where('diaries_id',$diary->id)->delete();
            //更新処理
            $files = $request->file('files');
            foreach($files as $file){
                //ファイル名の取得
                $file_name = $file->getClientOriginalName();
                $file_random = Str::random(15);
                //ファイルの保存
                $file->storeAS('public/',$day_now.$file_random.'_'.$file_name);
                //DBへのファイル名とパスの保存
                $diary_image = new Diary_image();
                $diary_image->path = 'storage/' .$day_now.$file_random.'_'.$file_name;
                $diary_image->name = $file_name;
                $diary_image->diaries_id = $diary->id;
                $diary_image->save();
            }
        }else{
            //何もしない
            }
        return redirect()->route('edit.diary', ['diary' => $diary->id]);
    }
    
    //削除
    public function delete(Diary $diary)
   {
       $this->authorize('delete', $diary);
       
       $diary->delete();
       
       return redirect()->route('calendar');
   }
}
