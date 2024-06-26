<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


use App\Models\Normal_event;
use App\Models\NormaleventUser;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        
        

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        
        $watchword = "合言葉がまだ決まっていません";
        $user = User::find(Auth::user()->id);
        //$user->role = "member";
        $user->watchword = $watchword;
        $user->save();
        
        //通常行事登録
        $id = Auth::user()->id;
        $users = User::find($id);
        $events = Normal_event::all();
        //dd($id);
        foreach($events as $event){
        $user->normal_events()->syncWithoutDetaching($event->id,['notice'=>0,'day_num'=>5]);
        }
        return redirect(RouteServiceProvider::HOME);
    }
}
