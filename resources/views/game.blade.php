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
                        <div class="col-sm-3">
                            <p> kaut las</p>
                        </div>
                        <div class="col">
                            <img style="height:25vw;width:25vw;" src="{{$game->photo_url}}">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
