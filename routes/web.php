<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\MyEventController;
use App\Http\Controllers\InquiryMailController;

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

//ここに上のやつ全部いれる
//ログインしないと見れないところに後でいれる
//カレンダー表示：FullCalendar採用
Route::controller(CalendarController::class)->middleware(['auth'])->group(function(){
    Route::get('/calendar', 'index')->name('calendar');
});

//DiaryController
//日記作成
Route::controller(DiaryController::class)->middleware(['auth'])->group(function(){
    Route::get('/create', 'create')->name('create.diary');
    Route::post('/create', 'store')->name('store.diary');
    //日記内容閲覧
    Route::get('/show/{diary}','show')->name('show.diary');
    //日記編集
    Route::get('/edit/{diary}', 'edit')->name('edit.diary');
    Route::put('/edit/{diary}', 'update')->name('update.diary');
});

//MyEventController
Route::controller(MyEventController::class)->middleware(['auth'])->group(function(){
    Route::get('/myevent/create', 'create')->name('create.myevent');
    Route::post('/myevent/create', 'store')->name('store.myevent');
});

//InquiryMailController
Route::controller(InquiryMailController::class)->middleware(['auth'])->group(function(){
    Route::get('/mail/create', 'create')->name('inquiry.create');
    Route::post('/mail/create', 'store')->name('inquiry.store');
});

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';






