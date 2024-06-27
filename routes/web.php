<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('top');
});

// この行を追記 midlewareにauthを入れることで、認証済みか判定　共通の処理をグルーピング化
// また、Route::groupの引数として'prefix' => 'users'という表記をすることで、
// Urlの先頭にusersが付与されることになります。Urlはhttp://localhost:8000/users/show/1という形
Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    // Route::get('show/{id}', 'App\Http\Controllers\UserController@show')->name('users.show');
    Route::get('show/{id}', [App\Http\Controllers\UserController::class,'show'])->name('users.show');
    Route::get('edit/{id}', [App\Http\Controllers\UserController::class,'edit'])->name('users.edit');
    Route::post('update/{id}', [App\Http\Controllers\UserController::class,'update'])->name('users.update');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function(){
    return view('top');
});

Route::get('/matching', 'App\Http\Controllers\MatchingController@index')->name('matching'); //追加7-1

// ここから追加8-2
Route::group(['prefix' => 'chat', 'middleware' => 'auth'], function () {
    Route::post('show', 'App\Http\Controllers\ChatController@show')->name('chat.show');
    Route::post('chat', 'App\Http\Controllers\ChatController@chat')->name('chat.chat'); // この行を追加します。8-5
});