<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;

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

//ログインしないと見れないところに後でいれる
//カレンダー表示：FullCalendar採用
//名前はまだ
Route::get('/calendar', [CalendarController::class, 'index']);
Route::get('/create', [DiaryController::class, 'create']);
Route::post('/create', [DiaryController::class, 'create']);

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

/**
*個人イベント登録画面へ遷移する
*/

//ログインしないと見れない
Route::middleware(['auth', 'verified'])->group(function (){
    Route::get('/dashboard', function () {
        return view('dashboard');
})->name('dashboard');



});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';






