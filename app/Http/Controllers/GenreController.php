<?php

namespace App\Http\Controllers;
use App\Models\Genre;
use Validator;
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
        $request->validate([
            'name'=> 'required|string|max:15',
            'description' => 'nullable|string|max:40',
        ]);
        $genre = new Genre;
        $genre->name=$request->name;
        $genre->description=$request->description;
        $genre->save();
        return redirect()->route('home','date');
    }
}
