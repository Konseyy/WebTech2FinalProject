<?php

namespace App\Http\Controllers;
use App\Models\Game;
use Illuminate\Http\Request;

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
        echo "make new game here";
    }
    public function store(Request $request){
        //Store game from incoming request from create method form
    }
    public function show($id){
        //Show game with specific ID
    }
    public function delete($id){
        //Delete game with specific ID
    }
}
