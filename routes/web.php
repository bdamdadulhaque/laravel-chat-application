<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
// auth
Auth::routes();
// home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// user list chat 
Route::get('/user-list', [App\Http\Controllers\MessageController::class, 'userList'])->name('user-list');
// user message show
Route::get('/user-message/{id}', [App\Http\Controllers\MessageController::class, 'userMessage'])->name('user-message');
// user message send
Route::post('/message-send', [App\Http\Controllers\MessageController::class, 'messageSend'])->name('message-send');
