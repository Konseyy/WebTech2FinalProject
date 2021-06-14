@extends('layouts.app')
@section('content')
<div class="container col">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <form method="POST" action="{{route('game.new')}}">
                @csrf
                <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <input type="hidden" name="user_id" value={{$id}}>
                    </div>
                    <div class="row">
                        <input class="col-md-10 form-control" type="text" name="name" placeholder="Game name...">
                    </div>
                    <div class="row">
                        <input class="col-md-10 form-control" type="text" name="developer" placeholder="Developer name...">
                    </div>
                    <div class="row">
                            @if(isset($genres))
                            <select class="col-md-5 form-control" name="genre">
                            @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->name}}</option>
                            @endforeach
                            </select>
                            @endif 
                            <a class="col-md-4 offset-md-1 btn btn-block btn-secondary" href="{{route('genre.new')}}">Create new</a>
                    </div>
                    <div class="row">
                        <input class="col-md-10 form-control form-group-lg" type="text" name="description" placeholder="Description...">
                    </div>
                    <div class="row">
                        <input class="col-md-10 btn btn-block btn-secondary" type="submit">
                    </div>
                </div>
                <div class="col-sm-auto offset-md-1">
                <label for="file">Cover Photo (max 2MB)</label>
                    <input class="btn btn-block btn-secondary" type="file" name="file" placeholder="cover photo">
                </div>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection