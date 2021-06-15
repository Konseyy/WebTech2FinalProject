@extends('layouts.app')
@section('content')
<div class="container col">
    <div class="row justify-content-start">
        <div class="col-sm-2">
            <div class="card">
                @auth
                    <div class="card-header text-center" style="font-size:20px;">
                        {{ __('Options') }}
                    </div>
                    <div class="card-body col">
                        <div class="row">
                            <label style="padding-top:5px;" class="btn-block col" for="order">Sort By</label>
                            <select name="order" style="margin-right:10%" class="custom-select col-sm-8">
                            <option>Date</option>
                            <option>Views</option>
                            </select>
                        </div>
                        @if(isset($caption) and $caption!="Catalog")
                        <a class="btn btn-info btn-block" href="{{route('home','date')}}">View all Games</a>
                        @endif
                        
                        <a class="btn btn-info btn-block" href="{{route('game.new')}}">Upload New Game</a>
                        <a class="btn btn-info btn-block" href="{{route('genre.new')}}">Add New Game Genre</a>
                        
                    </div>
                @endauth
                @guest
                    <div class="card-header text-center" style="font-size:20px;">
                        Log in to see options
                    </div>

                @endguest
            </div>
        </div>
        <div class="col">
            <div class="card">
            <div class="card-header" style="font-size:30px;">
            {{$caption}}
            @if($games->first()->genre->description!='')
                <p class="text-muted" style="font-size:20px;">{{$games->first()->genre->description}}</p>
            @endif
            </div>
                <div class="card-body col">
                    <div class="row">
                    @if($order=="date")
                        @foreach($games->sortByDesc('created_at') as $game)
                            <div class="img-thumbnail">
                                <h3 style="text-transform:capitalize;">
                                    <a href="{{route('game.show',$game->id)}}" class="text-dark">
                                        {{$game->name}}
                                    </a>
                                </h3>
                                <h3 class="text-primary" >
                                            <a href="{{route('home.filter',['order'=>'date','filter'=>'genre','id'=>$game->genre->id])}}" style="text-transform:capitalize;">
                                                {{$game->genre->name}}
                                            </a>
                                </h3>
                                <h3 style="text-transform:capitalize;" class="text-muted">
                                    <a href="{{route('home.filter',['order'=>'date','filter'=>'dev','id'=>$game->developer])}}" class="text-muted">
                                        {{$game->developer}}
                                    </a>
                                </h3>
                                <a href="{{route('game.show',$game->id)}}">
                                    <img style="height:12vw; width:12vw;"  src="{{$game->photo_url}}">
                                </a>
                            </div> 
                        @endforeach
                    @else
                        @foreach($games->sortByDesc('views_count') as $game)
                            <div class="img-thumbnail">
                                <h3 style="text-transform:capitalize;">
                                    <a href="{{route('game.show',$game->id)}}" class="text-dark">
                                        {{$game->name}}
                                    </a>
                                </h3>
                                <h3 class="text-primary" >
                                            <a href="{{route('home.filter',['order'=>'date','filter'=>'genre','id'=>$game->genre->id])}}" style="text-transform:capitalize;">
                                                {{$game->genre->name}}
                                            </a>
                                </h3>
                                <h3 style="text-transform:capitalize;" class="text-muted">
                                    <a href="{{route('home.filter',['order'=>'date','filter'=>'dev','id'=>$game->developer])}}" class="text-muted">
                                        {{$game->developer}}
                                    </a>
                                </h3>
                                <a href="{{route('game.show',$game->id)}}">
                                    <img style="height:12vw; width:12vw;"  src="{{$game->photo_url}}">
                                </a>
                            </div> 
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
