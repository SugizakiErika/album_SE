<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary_image;
use App\Models\Diary;
use App\Models\User;

use Illuminate\Support\Facades\Storage;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Diary_image $diary_image,User $user,Request $request)
    {
        $date = $request->input('date');
        
        return view('diary.create')->with(['diary_images' => $diary_image->get()])->with(['date' => $date])->with(['user' => $user->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //日記の登録
    public function store(Diary $diary,Diary_image $diary_image,User $user,Request $request)
    {
        //title,date,comment,color,users_idの保存
        $input = $request['diary'];
        $diary->start = $input["start"];
        $diary->title = $input["title"];
        $diary->comment = $input["comment"];
        $diary->color = "#FFCCFF";
        $diary->url = '/show/' .$diary->id;
        $diary->users_id = $user->id;
        $diary->save();
        $diary->url = '/show/' .$diary->id;
        $diary->save();
        
        $files = $request->file('file');
        
        foreach($files as $file){
            //ファイル名の取得
            $file_name = $file->getClientOriginalName();
            //ファイルの保存
            $file->storeAS('public/',$file_name);
            //DBへのファイル名とパスの保存
            $diary_image->path = 'storage/' .$file_name;
            $diary_image->name = $file_name;
            $diary_image->diaries_id = $diary->id;
            $diary_image->save();
        }
        
        return redirect('/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Diary $diary)
    {
    
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
        return view('diary.edit')->with(['diary' => $diary]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Diary $diary,Diary_image $diary_image,User $user)
    {
        //title,date,comment,color,users_idの保存
        $input = $request['diary'];
        $diary->start = $input["start"];
        $diary->title = $input["title"];
        $diary->comment = $input["comment"];
        $diary->color = "#FFCCFF";
        $diary->url = '/edit/' .$diary->id;
        $diary->users_id = $user->id;
        $diary->save();
        
        //画像の更新をする場合は一度削除してから更新する
        if($request->hasFile('file'))
        {
            //削除処理
            $diary_image->where('diaries_id',$diary->id)->delete();
            //更新処理
            $files = $request->file('file');
            foreach($files as $file){
                //ファイル名の取得
                $file_name = $file->getClientOriginalName();
                //ファイルの保存
                $file->storeAS('public/',$file_name);
                //DBへのファイル名とパスの保存
                $diary_image->path = 'storage/' .$file_name;
                $diary_image->name = $file_name;
                $diary_image->diaries_id = $diary->id;
                $diary_image->save();
            }
        }else{
            //何もしない
            }
        return redirect('/edit/'.$diary->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    //削除
    public function delete(Diary $diary,Diary_image $diary_image)
   {
       $diary->delete();
       $diary_image->delete();
       return redirect('/Calendar/edit/' . $user->id);
 }
}
