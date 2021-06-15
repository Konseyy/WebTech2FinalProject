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
    return redirect()->route('home',['order'=>'date']);
});
// Route::get('/home', function () {
//     return redirect()->route('home','date');
// });

Auth::routes();

Route::get('/home/{order}', 'GameController@index')->name('home');
Route::get('/home/{order}/{filter}/{id}','GameController@index')->name('home.filter');

Route::get('/game/new', 'GameController@create')->name('game.new');
Route::post('/game/new', 'GameController@store')->name('game.new');
Route::get('game/{game_id}','GameController@show')->name('game.show');
Route::get('game/{game_id}/edit','GameController@edit')->name('game.edit');
Route::post('game/edit','GameController@update')->name('game.update');
Route::post('game/delete','GameController@delete')->name('game.delete');

Route::get('/genre/new','GenreController@create')->name('genre.new');
Route::post('/genre/new','GenreController@store')->name('genre.new');

Route::post('/comment','CommentController@store')->name('comment.new');
Route::post('/comment/delete','CommentController@delete')->name('comment.delete');




