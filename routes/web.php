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

//ログインしないと見れないところに後でいれる
//カレンダー表示：FullCalendar採用
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');


//DiaryController
Route::get('/create', [DiaryController::class, 'create'])->name('create.diary');
Route::post('/create', [DiaryController::class, 'store'])->name('store.diary');

Route::get('/show/{diary}',[DiaryController::class, 'show'])->name('show.diary');

Route::get('/edit/{diary}',[DiaryController::class, 'edit'])->name('edit.diary');
Route::put('/edit/{diary}',[DiaryController::class, 'update'])->name('update.diary');

//MyEventController
Route::get('/myevent/create',[MyEventController::class,'create'])->name('create.myevent');
Route::post('/myevent/create',[MyEventController::class,'store'])->name('store.myevent');

//mail
Route::get('/mail/send',[InquiryMailController::class,'send'])->name('Inquiry.send');


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






