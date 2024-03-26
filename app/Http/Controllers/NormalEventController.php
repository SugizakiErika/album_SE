<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Normal_event;
use App\Models\User;
use App\Models\NormaleventUser;

use Illuminate\Support\Facades\Auth;

class NormalEventController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Normal_event $normal_event)
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('normal_event.edit')->with(['users' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request["n_event"];
        //dd($input);
        
        $id = Auth::user()->id;
        $user = User::find($id);
        //$user->normal_events()->syncWithPivotValues(1,['notice'=>1,'day_num'=>8],false);
        $user->normal_events()->syncWithPivotValues($input["id"],['notice'=>$input["notice"],'day_num'=>$input["day_num"]],false);
        
        //$normal_event->url = '/myevent/edit/' .$my_event->id;
        
        
        return redirect()->route('create.normalevent', ['id' => 1]);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
     public function show(Normal_event $normal_event)
     {
         return view('normal_event.show')->with(['normal_event' => $normal_event]);
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
        
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->normal_events()
             ->syncWithPivotValues($result["ajax_input_id"],
                                  ['notice'=>$result["ajax_input_notice"],
                                  'day_num'=>$result["ajax_input_day_num"]],false);
                                  
        return $result;
    }
}
