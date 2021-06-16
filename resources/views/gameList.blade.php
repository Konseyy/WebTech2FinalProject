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
                        <div style="margin-bottom:20px;" class="row col">
                            <label style="padding-top:5px;" class="btn-block col-sm-5" for="order">Sort By</label>
                            <div class="row col" name="order">
                                
                                @if($params['filter']==NULL)
                                    <a class="btn btn-block btn-info" href="{{route('home','date')}}">Date</a>
                                    <a class="btn btn-block btn-info" href="{{route('home','views')}}">Views</a>
                                @else
                                    <a class="btn btn-block btn-info" href="{{route('home.filter',['order'=>'date','filter'=>$params['filter'],'id'=>$params['id']])}}">Date</a>
                                    <a class="btn btn-block btn-info" href="{{route('home.filter',['order'=>'views','filter'=>$params['filter'],'id'=>$params['id']])}}">Views</a>
                                @endif
                            </div>
                        </div>
                        @if(isset($caption) and $caption!="Catalog")
                        <a class="btn btn-info btn-block" href="{{route('home','date')}}">View all Games</a>
                        @endif
                        
                        <a class="btn btn-info btn-block" href="{{route('game.new')}}">Upload New Game</a>
                        <a class="btn btn-info btn-block" href="{{route('genre.new')}}">Add New Game Genre</a>
                        
                    </div>
                    <div class="card-header text-center" style="font-size:20px;">
                        Your recently viewed
                        
                    </div>
                    <div class="card-body col">
                    @if(!$recentGames->isEmpty())
                            @foreach($recentGames as $game)
                                <div style="margin-bottom:5px; justify-content:center" class="row">
                                    <a style="width:75%" class="btn btn-block btn-secondary" href="{{route('game.show',$game->id)}}" style="text-transform:capitalize;">{{$game->name}}</a>
                                </div>
                            @endforeach
                        @else
                            <div style="justify-content:center" class="row">
                                No recently viewed games
                            </div>
                        @endif
                    </div>
                    
                @endauth
                @guest
                    <div class="card-header text-center" style="font-size:20px;">
                        <a href="{{route('login')}}">Log in</a> to see options
                    </div>

                @endguest
            </div>
        </div>
        <div class="col">
            <div class="card">
            <div class="card-header" style="font-size:30px;">
            {{$caption}}
            @if($params['filter']!='search')
                @if($games->first()->genre->description!='')
                    <p class="text-muted" style="font-size:20px;">{{$games->first()->genre->description}}</p>
                @endif
            @endif
            </div>
                <div class="card-body col">
                    <div class="row">
                    @if($params['order']=="date")
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
