<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:15',
            'game_id'=> 'required',
            'name' => Rule::unique('tags')->where(function ($query) use($request) {
                return $query->where('game_id', $request->game_id);
            }),
        ]);
        $tag = new Tag;
        $tag->name=$request->name;
        $tag->game_id=$request->game_id;
        $tag->save();
        return back();
    }
    public function delete($game_id,$name){
        Tag::where('game_id',$game_id)->where('name',$name)->delete();
        return back();
    }
}
