<?php

namespace App\Http\Controllers;
use App\Models\Game;
use App\Models\Genre;
use App\Models\View;
use App\Models\Comment;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class GameController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('index','show');
    }
    public function index($order='date',$filter=NULL,$id=NULL){
        //TODO sortinggggg
        if(is_null($filter)){
            $games = Game::withCount('views')->with('genre')->get();
            $caption="Catalog";
        }
        else if($filter=='genre'){
            $games = Game::withCount('views')->with('genre')->where('genre_id',$id)->get();
            $caption = "Genre: ".Genre::where('id',$id)->first()->name;
            $description = Genre::where('id',$id)->first()->description;
        }
        else if($filter=='dev'){
            $games = Game::withCount('views')->with('genre')->where('developer', $id)->get();
            $caption = "All games made by ".$id;
        }
        else if($filter=='user'){
            $games = Game::withCount('views')->with('genre')->with('user')->where('user_id', $id)->get();
            $caption = "All games uploaded by ".User::where('id',$id)->first()->name;
        }
        if($order=='date'){
            $games->sortByDesc('created_at');
        }
        else if($order=='views'){
            $games->sortByDesc('views_count');
        }
        return view('gameList',compact('games','caption'));
    }
    public function create(){
        $id=Auth::user()->id;
        $genres = Genre::all();
        return view('gameCreate',compact('id','genres'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:25',
            'user_id'=> 'required',
            'genre' => 'required',
            'developer' => 'required|string|max:25',
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
    public function edit($game_id){
        $game = Game::where('id',$game_id)->first();
        if(Auth::user()->id!=$game->user_id and Auth::user()->role!='admin'){
            return redirect()->route('home');
        }
        $genre = Genre::where('id',$game->genre_id)->first();
        $genres = Genre::all();
        return view('gameEdit',compact('game','genre','genres'));
    }
    public function update(Request $request){
        $request->validate([
            'game_id' => 'required',
            'name' => 'nullable|string|max:25',
            'genre' => 'nullable',
            'developer' => 'nullable|string|max:25',
            'description' => 'nullable|string|max:100',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $game = Game::where('id',$request->game_id)->first();
        if(Auth::user()->id!=$game->user_id and Auth::user()->role!='admin'){
            return redirect()->route('home');
        }
        if($request->name!=''){
            Game::where('id',$request->game_id)->update(['name'=>$request->name]);
        }
        if($request->genre!=''){
            Game::where('id',$request->game_id)->update(['genre_id'=>$request->genre]);
        }
        if($request->developer!=''){
            Game::where('id',$request->game_id)->update(['developer'=>$request->developer]);
        }
        Game::where('id',$request->game_id)->update(['description'=>$request->description]);
        if($request->file('file')!=''){
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
            Game::where('id',$request->game_id)->update(['photo_url'=>$data['file']]);
        }
        return redirect()->route('game.show',$request->game_id);
    }
    public function show($game_id){
        //Show game with specific ID and add view
        $guest=false;
        $user = Auth::user();
        $view = new View;
        $view->game_id=$game_id;
        if(!Auth::guest()){
            $view->user_id= $user->id;
        }
        $view->save();
        $game = Game::withCount('views')->where('id',$game_id)->with(['user','genre'])->first();
        $comments = Comment::where('game_id',$game->id)->with('user')->orderBy('created_at')->get();
        return view('game',compact('game','user','comments'));
    }
    public function delete(Request $request){
        //Delete game with specific ID
        $request->validate([
            'game_id' => 'required',
        ]);
        if(Auth::user()->id!=Game::where('id',$request->game_id)->first()->user_id and Auth::user()->role!='admin'){
            return redirect()->route('home');
        }
        View::where('game_id',$request->game_id)->delete();
        Game::where('id',$request->game_id)->delete();
        return redirect()->route('home');
    }
}
