<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

 use App\Models\User;
// use Illuminate\Support\Facades\Gate;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        //ログインするユーザーの情報を取得
        $user = Auth::user();
        
        //ログインしたら管理者画面に飛ぶ
        if($user->role == 'administrator'){
            return redirect(RouteServiceProvider::ADMIN);
        
        }elseif($user->role == null){ //ログインしたら会員画面に飛ぶ
        
        return redirect()->intended(RouteServiceProvider::HOME);
  
        }
            
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
