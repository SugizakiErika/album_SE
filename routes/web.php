<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


/**
*ホーム画面へ遷移する
*/

/**
*ログイン画面へ遷移する
*/
Route::get('/', function () {
    return redirect('/login');
});


//ログインしないと見れない
Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', function () {
        return view('dashboard');
})->name('dashboard');

//カレンダー表示：FullCalendar採用
//名前はまだ
Route::get('/calendar', function () {
    return view('calendar');
});

/**
*パスワード確認画面へ遷移する
*/

/**
*パスワード確認画面へ遷移する
*/

/**
*パスワード再設定画面へ遷移する
*/

/**
*パスワード登録完了画面へ遷移する
*/

/**
*新規作成画面へ遷移する
*/

/**
*新規作成完了画面へ遷移する
*/

/**
*個人イベント登録画面へ遷移する
*/

/**
*個人イベント登録完了画面へ遷移する
*/

/**
*通常行事登録画面へ遷移する
*/

/**
*通常行事登録完了画面へ遷移する
*/

/**
*メイン画面へ遷移する
*/

/**
*投稿画面へ遷移する
*/

/**
*問い合わせ画面へ遷移する
*/

/**
*公開リスト画面へ遷移する
*/


});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';






