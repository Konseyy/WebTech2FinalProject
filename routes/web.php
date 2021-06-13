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

Auth::routes();

Route::post('/image/upload/{gameid}','PhotoController@store')->name('image.upload');
Route::get('/game/new', 'GameController@create')->name('game.new');
Route::get('/home', 'GameController@index')->name('home');
