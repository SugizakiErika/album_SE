<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary_image;
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
    public function create(Diary_image $diary_image,Request $request)
    {
        $date = $request->input('date');
        
        return view('diary.create')->with(['diary_images' => $diary_image->get()])->with(['date' => $date]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //日記の登録
    public function store(Diary_image $diary_image,Request $request)
    {
    
        $files = $request->file('file');
        
        foreach($files as $file){
            //ファイル名の取得
            $file_name = $file->getClientOriginalName();
            //ファイルの保存
            $file->storeAS('public/',$file_name);
            //DBへのファイル名とパスの保存
            $diary_image->path = 'storage/' .$file_name;
            $diary_image->name = $file_name;
            $diary_image->save();
        }
        
        //title,date,comment,color,users_idの保存
        
        
        
        return redirect('/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
