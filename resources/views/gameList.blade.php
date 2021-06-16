@extends('layouts.app')
@section('content')
<div class="container col">
    <div class="row justify-content-start">
        <div class="col-sm-2">
            <div class="card">
                @auth
                    <div class="card-header text-center" style="font-size:20px;">
                    {{ __('strings.options') }}
                    </div>
                    <div class="card-body col">
                        @if(isset($caption) and $caption!="Catalog")
                            <a class="btn btn-info btn-block" href="{{route('home','date')}}">{{ __('strings.view_all') }}</a>
                        @endif
                        <a class="btn btn-info btn-block" href="{{route('game.new')}}">{{ __('strings.upload_game') }}</a>
                        <a class="btn btn-info btn-block" href="{{route('genre.new')}}">{{ __('strings.upload_genre') }}</a>
                        <div style="margin-bottom:20px;margin-top:20px;" class="row col">
                            <div class="col">
                                <div class="row">
                                <form method="POST" action="{{route('home.search')}}">
                                    @csrf
                                    <input name="searchTerm" class="col form-control" type="text" placeholder="{{ __('strings.search') }}">
                                    <input type="hidden" name="order" value="{{$params['order']}}" >
                                    <input class="btn btn-block btn-primary" type="submit" value="{{ __('strings.search') }}">
                                </form>
                                </div>
                                <div class="row">
                                <label style="padding-top:5px;" class="btn-block col-sm-5" for="order">{{ __('strings.sort_by') }}</label>
                                @isset($params)
                                    @if($params['filter']==NULL)
                                        <a class="btn btn-block btn-info" href="{{route('home','date')}}">{{ __('strings.by_date') }}</a>
                                        <a class="btn btn-block btn-info" href="{{route('home','views')}}">{{ __('strings.by_views') }}</a>
                                    @else
                                        <a class="btn btn-block btn-info" href="{{route('home.filter',['order'=>'date','filter'=>$params['filter'],'id'=>$params['id']])}}">{{ __('strings.by_date') }}</a>
                                        <a class="btn btn-block btn-info" href="{{route('home.filter',['order'=>'views','filter'=>$params['filter'],'id'=>$params['id']])}}">{{ __('strings.by_views') }}</a>
                                    @endif
                                @endisset
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-header text-center" style="font-size:20px;">
                        {{ __('strings.recent') }}
                    </div>
                    <div class="card-body col">
                        @isset($recentGames)
                            @if(!$recentGames->isEmpty())
                                @foreach($recentGames as $game)
                                    <div style="margin-bottom:5px; justify-content:center" class="row">
                                        <a style="width:75%" class="btn btn-block btn-secondary" href="{{route('game.show',$game->id)}}" style="text-transform:capitalize;">{{$game->name}}</a>
                                    </div>
                                @endforeach
                            @else
                                <div style="justify-content:center" class="row">
                                {{ __('strings.no_recent') }}
                                </div>
                            @endif
                        @endisset
                    </div>
                @endauth
                @guest
                    <div class="card-header text-center" style="font-size:20px;">
                        <a href="{{route('login')}}">{{ __('strings.login') }}</a> {{ __('strings.see_options') }}
                    </div>
                @endguest
            </div>
        </div>
        <div class="col">
            <div class="card">
                @isset($caption)
                    @isset($params)
                        @isset($games)
                            @if(!$games->isEmpty())
                                <div class="card-header" style="font-size:30px;">
                                {{$caption}}
                                @if($params['filter']!='search' and $params['filter']!='')
                                    @if($games->first()->genre->description!='')
                                        <p class="text-muted" style="font-size:20px;">{{$games->first()->genre->description}}</p>
                                    @endif
                                @endif
                                </div>
                            @endif
                        @endisset
                    @endisset
                @endisset
                <div class="card-body col">
                    <div class="row">
                        @isset($params)
                            @isset($games)
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
                            @endisset
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
