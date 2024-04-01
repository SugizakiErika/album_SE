<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        
        Log::info(Auth::user());
        
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) { //こいつが良く分かってないからわんちゃんエラー起きる
                
                //ログインするユーザーの情報を取得
                $user = Auth::user();
                //ログインしたら管理者画面に飛ぶ
                if($user->role == 'administrator'){
                    Log::info("管理者");
                    return redirect(RouteServiceProvider::ADMIN);
        
                }elseif($user->role == null){ //ログインしたら会員画面に飛ぶ
                    return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}
