<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function views(){
        return $this->hasMany(View::class);
    }
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
}
