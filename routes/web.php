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

// Route::get('/', function () {
//     return view('welcome');
// });

// change default route to login
Route::get('/', [App\Http\Controllers\LoginController::class, 'login'])->name('login');


// user register
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'storeUser']);

// user login
Route::get('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'authenticate']);
Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

// user dashboard no need
// Route::get('/dashboard', [App\Http\Controllers\LoginController::class, 'dashboard'])->name('dashboard');

// admin dasgboard
Route::get('/admin-dashboard', [App\Http\Controllers\AdminController::class, 'adminDashboard'])->name('admin-dashboard');
Route::get('/admin-user-list', [App\Http\Controllers\AdminController::class, 'userList'])->name('admin-user-list');

// customer home (dashboard)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); // customer dashboard
// user list chat 
Route::get('/user-list', [App\Http\Controllers\MessageController::class, 'userList'])->name('user-list');
// user message show
Route::get('/user-message/{id}', [App\Http\Controllers\MessageController::class, 'userMessage'])->name('user-message');
// user message send
Route::post('/message-send', [App\Http\Controllers\MessageController::class, 'messageSend'])->name('message-send');
