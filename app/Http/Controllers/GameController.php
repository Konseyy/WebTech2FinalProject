<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Genre;
use App\Models\View;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class GameController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $games = Game::all();
        $genres = Genre::all();
        return view('gameList',compact('games','genres'));
    }
    public function indexByGenre($genre_id){
        $games = Game::where('genre_id',$genre_id)->get();
        $genres = Genre::all();
        $caption = "All games classified as ".Genre::where('id',$genre_id)->first()->name;
        return view('gameList',compact('games','genres','caption'));
    }
    public function indexByDeveloper($developer_name){
        $games = Game::where('developer', $developer_name)->get();
        $genres = Genre::all();
        $caption = "All games made by ".$developer_name;
        return view('gameList',compact('games','genres','caption'));
    }
    public function indexByUser($user_id){
        $games = Game::where('user_id', $user_id)->get();
        $genres = Genre::all();
        $caption = "All games uploaded by ".User::where('id',$user_id)->first()->name;
        return view('gameList',compact('games','genres','caption'));
    }
    public function create(){
        $id=Auth::user()->id;
        $genres = Genre::all();
        return view('gameCreate',compact('id','genres'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:100',
            'user_id'=> 'required',
            'genre' => 'required',
            'developer' => 'required|string|max:100',
            'description' => 'nullable|string|max:100',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $file = $request->file('file');
        $file_path = $file->getPathName();
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://api.imgur.com/3/image', [
            'headers' => [
                    'authorization' => 'Client-ID ' . 'b61a2bc5daf215b',
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
            'form_params' => [
                    'image' => base64_encode(file_get_contents($request->file('file')->path($file_path)))
                ],
            ]);
        $data['file'] = data_get(response()->json(json_decode(($response->getBody()->getContents())))->getData(), 'data.link');
        $game = new Game;
        $game->name = $request->name;
        $game->photo_url=$data['file'];
        $game->user_id = $request->user_id;
        $game->genre_id = $request->genre;
        $game->developer = $request->developer;
        $game->description = $request->description;
        $game->save();
        return redirect()->route('home');
        //Store game from incoming request from create method form
    }
    public function show($id){
        //Show game with specific ID and add view
        $user = Auth::user();
        $view = new View;
        $view->game_id=$id;
        $view->user_id= $user->id;
        $view->save();
        $game = Game::where('id',$id)->first();
        $uploader = User::where('id',$game->user_id)->first();
        $genre = Genre::where('id',$game->genre_id)->first();
        $viewCount = count(View::where('game_id',$id)->get());
        return view('game',compact('game', 'genre','user','uploader','viewCount'));
    }
    public function delete(Request $request){
        //Delete game with specific ID
        $request->validate([
            'game_id' => 'required',
        ]);
        View::where('game_id',$request->game_id)->delete();
        Game::where('id',$request->game_id)->delete();
        return redirect()->route('home');
    }
}
