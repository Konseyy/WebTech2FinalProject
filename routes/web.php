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

Route::get('/game/new', 'GameController@create')->name('game.new');
Route::post('/game/new', 'GameController@store')->name('game.new');
Route::post('/image/upload/{gameid}','PhotoController@store')->name('image.upload');
Route::get('/genre/new','GenreController@create')->name('genre.new');
Route::post('/genre/new','GenreController@store')->name('genre.new');

Route::get('/home', 'GameController@index')->name('home');
