@extends('layouts.app')
@section('content')
<div class="container col">
    <div class="row justify-content-start">
        <div class="col-sm-2">
            <div class="card">
                <div class="card-header text-center">{{ __('Options') }}</div>
                <div class="card-body col">
                    <a class="btn btn-info btn-block" href="{{route('game.new')}}">Upload New Game</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('Gallery') }}</div>
                <div class="card-body col-md-2">
                    @foreach($games as $game)
                        <p>$game->id</p>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
