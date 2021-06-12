<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function photos(){
        return $this->hasMany(Photo::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function genre(){
        return $this->belongsTo(Genre::class);
    }
    public function keywords(){
        return $this->belongsToMany(Keyword::class);
    }
}
