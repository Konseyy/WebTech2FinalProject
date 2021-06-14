<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function create(){
        return view('genreCreate');
    }
    public function store(Request $request){
        $genre = new Genre;
        $genre->name=$request->name;
        $genre->description=$request->description;
        $genre->save();
        return redirect()->route('home');
    }
}
