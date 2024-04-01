<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\MyEventController;
use App\Http\Controllers\NormalEventController;
use App\Http\Controllers\InquiryMailController;
use App\Http\Controllers\AdminController;


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

});
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
    //削除
    Route::delete('/show/{diary}','delete')->name('delete.diary');
});

//MyEventController
Route::controller(MyEventController::class)->middleware(['auth'])->group(function(){
    //削除
    Route::get('/myevent/create/{my_event}', 'create')->name('create.myevent');
    Route::delete('/myevent/create/{my_event}','delete')->name('delete.myevent');
    
    Route::get('/myevent/create', 'create')->name('create.myevent');
    Route::post('/myevent/create', 'store')->name('store.myevent');
    Route::put('/myevent/update', 'update')->name('update.myevent');
    Route::get('/myevent/show/{my_event}', 'show')->name('show.myevent');
});

//NromalEventController
Route::controller(NormalEventController::class)->middleware(['auth'])->group(function(){
    Route::get('/normalevent/create', 'create')->name('create.normalevent');
    //Route::put('/normalevent/create', 'store')->name('store.normalevent');
    Route::put('/normalevent/update', 'update')->name('update.normalevent');
    Route::get('/normalevent/show/{normal_event}', 'show')->name('show.normalevent');
});


//InquiryMailController
Route::controller(InquiryMailController::class)->middleware(['auth'])->group(function(){
    Route::get('/mail/create', 'create')->name('inquiry.create');
    Route::post('/mail/create', 'store')->name('inquiry.store');
});

//管理者画面
//can:isAdminで管理者のみ入ること可能にする
Route::controller(AdminController::class)->middleware(['auth', 'can:isAdmin'])->group(function(){
    Route::get('/admin','index')->name('admin.index');//目次
    //メール送信
    Route::get('/admin/mail/create','create')->name('admin.create');
    Route::post('/admin/mail/create','store')->name('admin.store');
    //日記一覧
    Route::get('/admin/diary/show','d_show')->name('admin.d_show');
    Route::get('/admin/diary/create/{diary}','d_edit')->name('admin.d_edit');
    // Route::put('/admin/diary/create/{diary}','d_update')->name('admin.d_update');
     Route::delete('/admin/diary/show/{diary}','d_delete')->name('admin.d_delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';






