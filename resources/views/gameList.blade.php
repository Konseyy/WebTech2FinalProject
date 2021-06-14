@extends('layouts.app')
@section('content')
<div class="container col">
    <div class="row justify-content-start">
        <div class="col-sm-2">
            <div class="card">
            @if(!Auth::guest())
                <div class="card-header text-center" style="font-size:20px;">{{ __('Options') }}</div>
                <div class="card-body col">
                    @if(isset($caption))
                    <a class="btn btn-info btn-block" href="{{route('home')}}">View all Games</a>
                    @endif
                    
                    <a class="btn btn-info btn-block" href="{{route('game.new')}}">Upload New Game</a>
                    <a class="btn btn-info btn-block" href="{{route('genre.new')}}">Add New Game Genre</a>
                    
                </div>
                @else
                <div class="card-header text-center" style="font-size:20px;">Log in to see options</div>

                @endif
            </div>
        </div>
        <div class="col">
            <div class="card">
            @if(!isset($caption))
                <div class="card-header" style="font-size:30px;">{{ __('Catalog') }}</div>
            @else
            <div class="card-header" style="font-size:30px;">{{$caption}}
            @if(isset($description))
             <p class="text-muted" style="font-size:20px;">{{$description}}</p>
            @endif
            </div>
            @endif
                <div class="card-body col">
                <div class="row">
                @foreach($games as $game)
                    <div class="img-thumbnail">
                        <h3 style="text-transform:capitalize;">
                        <a href="{{route('game.show',$game->id)}}" class="text-dark">
                        {{$game->name}}
                        </a>
                        </h3>
                        <h3 class="text-primary" >
                        @foreach($genres as $genre)
                        @if($genre->id==$game->genre_id)
                        <a href="{{route('home.genre',$genre->id)}}" style="text-transform:capitalize;">
                        {{$genre->name}}
                        </a>
                        @endif
                        @endforeach
                        </h3>
                        <h3 style="text-transform:capitalize;" class="text-muted">
                        <a href="{{route('home.dev',$game->developer)}}" class="text-muted">
                        {{$game->developer}}
                        </a>
                        </h3>
                        <a href="{{route('game.show',$game->id)}}">
                        <img style="height:12vw; width:12vw;"  src="{{$game->photo_url}}">
                        </a>
                    </div> 
                @endforeach
                </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
