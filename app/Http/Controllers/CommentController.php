<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function store(Request $request){
        $request->validate([
            'user_id' => 'required',
            'game_id'=> 'required',
            'content' => 'required|string|max:60',
        ]);
        $comment = new Comment;
        $comment->user_id=$request->user_id;
        $comment->game_id=$request->game_id;
        $comment->content=$request->content;
        $comment->save();
        return back();
    }
    public function delete(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        if(Auth::user()->id!=Comment::where('id',$request->id)->first()->user_id and Auth::user()->role!='admin'){
            return redirect()->route('home');
        }
        Comment::where('id',$request->id)->delete();
        return back();
    }
}
