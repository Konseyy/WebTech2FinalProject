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
    return view('auth.login');
});

Route::get('login/google',[App\Http\Controllers\Auth\LoginController::class, 'google'])->name('login.google');
Route::get('login/google/redirect',[App\Http\Controllers\Auth\LoginController::class, 'google_redirect']);

Route::get('login/facebook',[App\Http\Controllers\Auth\LoginController::class, 'facebook'])->name('login.facebook');
Route::get('login/facebook/redirect',[App\Http\Controllers\Auth\LoginController::class, 'facebook_redirect']);


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
