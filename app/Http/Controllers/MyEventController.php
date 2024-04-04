<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MyEventRequest;
use App\Models\My_event;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Diary;
use App\Models\Diary_image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class MyEventController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(My_event $my_event)
    {
        $id = Auth::user()->id;
        //dd($my_event->where('users_id',$id)->get());
        return view('myevent.create')->with(['my_events' => $my_event->where('users_id',$id)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(My_event $my_event,MyEventRequest $request)
    {
        $input = $request['myevent'];
        $my_event->start = Carbon::parse($input["start"])->format('m-d');
        $my_event->f_end = Carbon::parse($input["start"])->format('m-d');
        $my_event->title = $input["title"];
        $my_event->category = $input["category"];
        $my_event->day = $input["day"];
        $my_event->color = "#9999FF";
        $my_event->url = '/myevent/show/' .$my_event->id;
        $my_event->users_id = Auth::user()->id;
        $my_event->save();
        
        $my_event->url = '/myevent/show/' .$my_event->id;
        $my_event->save();
        
        return redirect()->route('create.myevent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(My_event $my_event)
    {
        $this->authorize('view', $my_event);
        $id = Auth::user()->id;
        $now = Carbon::now();
        $now_year = $now->year;
        
        $sum_last_date = [];
        for($i=2022; $i<$now_year; $i++ ){
        
        $last_year = $i;
        $last_date = $last_year.'-'.$my_event->start;
        
        array_push($sum_last_date, $last_date);
        }
        $diary =Diary::where('users_id',$id)->whereIn('start',$sum_last_date)->with(['diary_images'])->get();
        //$diary->concat($date);
        //Log::info($diary);
        
    //dd($diary);
        return view('myevent.show')->with(['my_event' => $my_event])->with(['diary' => $diary]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $result = $request->all();
        
        $my_event = MY_event::find($result["ajax_input_id"]);
        $title = json_encode($result["ajax_input_title"],JSON_UNESCAPED_UNICODE);
    
        $my_event->start = Carbon::parse($result["ajax_input_start"])->format('m-d');
        $my_event->f_end = Carbon::parse($result["ajax_input_start"])->format('m-d');
        $my_event->title = json_decode($title); //""が付いてしまうのでdecodeする
        $my_event->category = $result["ajax_input_category"];
        $my_event->day = $result["ajax_input_day"];
        $my_event->color = "#9999FF";
        $my_event->url = '/myevent/show/' .$result["ajax_input_id"];
        $my_event->users_id = Auth::user()->id;
        $my_event->save();
        
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(My_event $my_event)
    {
        $this->authorize('delete', $my_event);
        $my_event->delete();
        
        //$my_events = MY_event::all();
        
        return $my_event;
    }
}
