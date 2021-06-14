@extends('layouts.app')
@section('content')
<div class="container col">
    <div class="row justify-content-start">
        <div class="col-sm-2">
            <div class="card">
                <div class="card-header text-center" style="font-size:20px;">{{ __('Options') }}</div>
                <div class="card-body col">
                    <a class="btn btn-info btn-block" href="{{route('home')}}">Back to Catalog</a>
                    @if($game->user_id==$user->id or $user->role=='admin')
                    <a class="btn btn-info btn-block" href="{{route('game.edit',$game->id)}}">Edit Game</a>
                    <form action="{{route('game.delete')}}" method="POST">
                    @csrf
                        <input type="hidden" name="game_id" value="{{$game->id}}">
                        <input type="submit" class="btn btn-info btn-danger col" value="Delete Game">
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header" style="font-size:30px;text-transform:capitalize;">{{ $game->name }}</div>
                
                    <div class="card-body col">
                    <div class="row">
                        <div style="padding-left:20px;" class="col-sm-3">
                            <div class="row">
                            <h2>Name: {{$game->name}}</h2>
                            </div>
                            <div class="row">
                            <h2>Developer: <a href="{{route('home.dev', $game->developer)}}">{{$game->developer}}</a></h2>
                            </div>
                            <div class="row">
                            <h2>Genre: <a href="{{route('home.genre', $genre->id)}}">{{$genre->name}}</a></h2>
                            </div>
                            <div style="margin-top:2vh;" class="row">
                            @if($game->description!='')
                            <h4 class="text-muted">{{$game->description}}</h4>
                            @else
                            <h4 class="text-muted">Game has no description</h4>
                            @endif
                            </div>
                            <div  class="row">
                            <h4 class="text-muted">Uploaded by: <a href="{{route('home.user',$uploader->id)}}">{{$uploader->name}}</a></h4>
                            </div>
                            <div  class="row">
                            <h4 class="text-muted">Views: {{$viewCount}}</h4>
                            </div>
                        </div>
                        <div class="col">
                            <img style="height:25vw;" src="{{$game->photo_url}}">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
