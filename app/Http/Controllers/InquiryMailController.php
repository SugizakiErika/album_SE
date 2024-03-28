<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InquiryMailRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryMail;
use App\Models\Inquiry_list;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InquiryMailController extends Controller
{
    public function create()
    {
        return view('inquiry.create');
    }
    
    public function store(Inquiry_list $inquiry_list,InquiryMailRequest $request)
    {
        //title,date,comment,color,users_idの保存
        $input = $request['inquiry'];
        $inquiry_list->date = Carbon::now();
        $inquiry_list->title = $input["title"];
        $inquiry_list->comment = $input["comment"];
        $inquiry_list->user_id = $input["user_id"];
        $inquiry_list->email = $input["email"];
        $inquiry_list->users_id = Auth::user()->id;
        
        $inquiry_list->save();
        
        $name = $input["user_id"];
        $email = $input["email"];
        $comment = $input["comment"];
        
        Mail::send(new InquiryMail($name,$email,$comment));
         return view('inquiry.send_fin')->with(['name' => $name])->with(['comment' => $comment]);
    }
}
