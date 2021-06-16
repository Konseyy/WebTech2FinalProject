@extends('layouts.app')
@section('content')
<div class="container col">
    <div class="row justify-content-start">
        <div class="col-sm-2">
            <div class="card">
                <div class="card-header text-center" style="font-size:20px;">{{ __('strings.options') }}</div>
                <div class="card-body col">
                    <a class="btn btn-info btn-block" href="{{route('home','date')}}">{{ __('strings.to_catalog') }}</a>
                        @auth
                            @if($game->user_id==$user->id or $user->role=='admin')
                                <a class="btn btn-info btn-block" href="{{route('game.edit',$game->id)}}">{{ __('strings.edit_game') }}</a>
                                <form action="{{route('game.delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="game_id" value="{{$game->id}}">
                                    <input type="submit" class="btn btn-info btn-danger col" value="{{ __('strings.delete_game') }}">
                                </form>
                            @endif
                        @endauth
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header" style="font-size:30px;text-transform:capitalize;">{{ $game->name }}</div>
                    <div class="card-body col">
                        <div class="row">
                            <div style="padding-left:20px;position:relative" class="col-sm-3">
                                <div class="row">
                                    <h2>{{ __('strings.dev') }}: <a href="{{route('home.filter', ['order'=>'date','filter'=>'dev','id'=>$game->developer])}}">{{$game->developer}}</a></h2>
                                </div>
                                <div class="row">
                                    <h2>{{ __('strings.genre') }}: <a href="{{route('home.filter', ['order'=>'date','filter'=>'genre','id'=>$game->genre->id])}}">{{$game->genre->name}}</a></h2>
                                </div>
                                <div style="margin-top:2vh;" class="row">
                                    @if($game->description!='')
                                        <h4 class="text-muted">{{$game->description}}</h4>
                                    @else
                                        <h4 class="text-muted">{{ __('strings.no_description') }}</h4>
                                    @endif
                                </div>
                                @auth
                                    @if($game->user_id==$user->id or $user->role=='admin')
                                        <form style="align-self:center;margin-bottom:20px;" method="POST" action="{{route('tag.new')}}">
                                            @csrf
                                            <input type="hidden" name="game_id" value={{$game->id}}>
                                            <input style="margin-bottom:10px;" class="col-sm-5 form-control" type="text" name="name" placeholder="{{ __('strings.add_tag') }}">
                                            <input class="col-sm-5 btn btn-block btn-primary" type="submit" value="{{ __('strings.add') }}">
                                        </form>
                                    @endif
                                @endauth
                                @if(!$tags->isEmpty())
                                    @auth
                                        <h3>{{ __('strings.tags') }}</h3>
                                        <ul>
                                        @foreach($tags as $tag)
                                            <li>
                                                @if($game->user_id==$user->id or $user->role=='admin')
                                                <p>{{$tag->name}} <a href="{{route('tag.delete',['game_id'=>$game->id,'name'=>$tag->name])}}" class="text-danger">{{ __('strings.remove') }}</a></p>
                                                @else
                                                <p>{{$tag->name}}</p>
                                                @endif
                                            </li>
                                        @endforeach
                                        </ul>
                                    @endauth
                                @endif
                                <div style="position:absolute;bottom:0;">
                                <div style="align-self:end" class="row">
                                    <h4 class="text-muted">{{ __('strings.views') }}: {{$game->views_count}}</h4>
                                </div>
                                <div style="align-self:end" class="row">
                                    <h4 class="text-muted">{{ __('strings.uploaded_by') }}: <a href="{{route('home.filter',['order'=>'date','filter'=>'user','id'=>$game->user->id])}}">{{$game->user->name}}</a></h4>
                                </div>
                                </div>
                            </div>
                            <div class="col">
                                <img style="height:25vw;" src="{{$game->photo_url}}">
                            </div>
                        </div>
                        @auth
                            <div class="row col">
                                <form  class="col" action="{{route('comment.new')}}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{$game->id}}" name="game_id">
                                    <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                                    <div class="row col">
                                        <input class="row col-sm-3 form-control" type="text" name="content" placeholder="{{ __('strings.add_comment') }}">
                                    </div>
                                    <div style="margin-top:10px;margin-bottom:20px" class="row col">
                                        <input class="btn btn-block btn-primary col-sm-2" type="submit" value="{{ __('strings.comment_act') }}">
                                    </div>
                                </form>
                            </div>
                        @endauth
                        @foreach($comments as $comment)
                            <div style="margin-bottom:5px;" class="img-thumbnail col-sm-2">
                                <div class="row">
                                    <h3 style="padding-left:5px;">
                                        <a class="text-dark" href="{{route('home.filter',['order'=>'date','filter'=>'user','id'=>$comment->user->id])}}">
                                            {{$comment->user->name}}
                                        </a>
                                    </h3>
                                    <p style="margin-left:auto;margin-right:5px;">
                                        {{$comment->created_at}}
                                    </p>
                                </div>
                                <p>{{$comment->content}}</p>
                                @auth
                                    @if($comment->user_id==$user->id or $user->role=='admin')
                                        <form method="POST" action="{{route('comment.delete')}}">
                                            @csrf
                                            <input type="hidden" name="id" value={{$comment->id}}>
                                            <input style="margin-left:auto;" type="submit" class="col-sm-4 btn btn-block btn-danger" value="{{ __('strings.delete') }}">
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
