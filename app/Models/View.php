<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public function game(){
        return $this->belongsTo(Game::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
