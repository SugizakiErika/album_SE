<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReleaseListController extends Controller
{
    // 公開者リスト一覧画面
    public function index()
    {
        return view('releaselist.index');
    }
    
    //公開者リスト検索画面
    public function serch()
    {
        return view('releaselist.serch');
    }
    
    //公開者リスト登録画面
    public function create()
    {
        return view('releaselist.create');
    }
}
