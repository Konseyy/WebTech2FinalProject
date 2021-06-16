@extends('layouts.app')
@section('content')
<div class="container col">
    <div class="row justify-content-center">
        <div class="col-sm-5">
            <form method="POST" action="{{route('genre.new')}}">
                @csrf
                    <div class="row">
                        <input class="col-md-10 form-control" type="text" name="name" placeholder="{{ __('strings.name') }}">
                    </div>
                    <div class="row">
                        <input class="col-md-10 form-control form-group-lg" type="text" name="description" placeholder="{{ __('strings.description_here') }}">
                    </div>
                    <div class="row">
                        <input class="col-md-10 btn btn-block btn-primary" type="submit" value="{{ __('strings.upload_genre') }}">
                    </div>
            </form>
        </div>
    </div>
</div>
    
@endsection