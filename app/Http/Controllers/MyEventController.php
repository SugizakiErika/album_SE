<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\My_event;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MyEventController extends Controller
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
    public function store(My_event $my_event,Request $request)
    {
        $input = $request['myevent'];
        $my_event->start = Carbon::parse($input["start"])->format('m-d');
        $my_event->title = $input["title"];
        $my_event->category = $input["category"];
        $my_event->day = $input["day"];
        $my_event->color = "#9999FF";
        $my_event->url = '/myevent/edit/' .$my_event->id;
        $my_event->users_id = Auth::user()->id;
        $my_event->save();
        
        $my_event->url = '/myevent/edit/' .$my_event->id;
        $my_event->save();
        
        return redirect('/myevent/create');
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
}
