@extends('layouts.app')
@section('content')
<div class="container col">
<form enctype="multipart/form-data" method="POST" action="{{route('game.update')}}">
    @csrf
    <div class="row justify-content-start">
    
    <input type="hidden" value="{{$game->id}}" name="game_id">
        <div class="col-sm-2">
            <div class="card">
                <div class="card-header text-center" style="font-size:20px;">{{ __('strings.options') }}</div>
                <div class="card-body col">
                    <input type="submit" class="btn btn-block btn-info" value="{{ __('strings.submit_changes') }}">
                    <a class="btn btn-danger btn-block" href="{{route('game.show',$game->id)}}">{{ __('strings.cancel') }}</a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header" ><input name="name" style="font-size:30px;text-transform:capitalize;" type="text" value="{{$game->name}}"></div>
                    <div class="card-body col">
                    <div class="row">
                        <div style="padding-left:20px;position:relative" class="col-sm-3">
                            <div class="row">
                            <h2>{{ __('strings.dev') }}: <input name="developer" type="text" value="{{$game->developer}}"></h2>
                            </div>
                            <div class="row">
                            <h2>{{ __('strings.genre') }}: <select name="genre">
                            @foreach($genres as $current)
                            @if($current->id==$genre->id)
                                <option selected="selected" value="{{$current->id}}">{{$current->name}}</option>
                            @else
                                <option value="{{$current->id}}">{{$current->name}}</option>
                            @endif
                            @endforeach
                            </select></h2>
                            </div>
                            <div style="margin-top:2vh;" class="row">
                            <input placeholder="{{ __('strings.description_here') }}" name="description" class="form-control" type="text" value="{{$game->description}}">
                            </div>
                        </div>
                        <div >
                            <label for="file">{{ __('strings.update_photo') }} (max 2MB)</label>
                            <input class="btn btn-block btn-secondary" type="file" name="file" placeholder="{{ __('strings.cover_photo') }}">
                            <img style="height:25vw;" src="{{$game->photo_url}}">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    </form>
</div>
@endsection
