@extends('layouts.master')

@section('content')
<div style="display: flex; justify-content: space-between; width: 70%">
    <div>
        <h1>Title : {{$book->title}}</h1>
        <h3>Genre : {{$book->genre->name}}</h3>
        <h3>Date de création : {{$book->created_at}}</h3>
        <h3>Date de mise à jour : {{$book->updated_at}}</h3>
        <h3>Status : {{$book->status}}</h3>

        <h2>Les auteurs : </h2>
        <ul>
            @forelse($book->authors as $author)
            <li>{{$author->name}}</li>
            @empty
            <li>Pas d'auteurs</li>
            @endforelse
        </ul>
    </div>
    @if(!empty($book->picture))
    <div>
        <h2>Image :</h2>
        <img src="{{asset('images/'.$book->picture->link)}}">
    </div>
    @endif
</div>
@endsection