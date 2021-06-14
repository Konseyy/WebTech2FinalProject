<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\Request;
use Auth;

class GameController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $games = Game::all();
        return view('gameList',compact('games'));
    }
    public function create(){
        $id=Auth::user()->id;
        $genres = Genre::all();
        return view('gameCreate',compact('id','genres'));
    }
    public function store(Request $request){
        $request->validate([
            'user_id '=> 'required|integer',
            'genre' => 'required|string',
            'developer' => 'rquired|string|max:100',
            'description' => 'string|max:800',
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
        return back();
        //Store game from incoming request from create method form
    }
    public function show($id){
        //Show game with specific ID
    }
    public function delete($id){
        //Delete game with specific ID
    }
}
