<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryMail;

class InquiryMailController extends Controller
{
    public function send(Request $request)
    {
        $name = 'テストユーザー';
        $email = '';
        
        Mail::send(new InquiryMail($name,$email));
         return view('inquiry.send');
    }
}
