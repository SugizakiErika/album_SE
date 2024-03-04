<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InquiryController extends Controller
{
    // 問い合わせ画面
    public function create()
    {
        return view('Inquiry.create');
    }
  
}
