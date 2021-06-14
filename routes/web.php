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

Route::get('home/genre/{genre_id}','GameController@indexByGenre')->name('home.genre');
Route::get('home/dev/{developer_name}','GameController@indexByDeveloper')->name('home.dev');
Route::get('home/user/{user_id}','GameController@indexByUser')->name('home.user');
Route::get('/game/new', 'GameController@create')->name('game.new');
Route::post('/game/new', 'GameController@store')->name('game.new');
Route::get('/genre/new','GenreController@create')->name('genre.new');
Route::post('/genre/new','GenreController@store')->name('genre.new');
Route::get('game/{game_id}','GameController@show')->name('game.show');
Route::get('game/edit/{game_id}','GameController@edit')->name('game.edit');
Route::post('game/delete','GameController@delete')->name('game.delete');



Route::get('/home', 'GameController@index')->name('home');
