@extends('layouts.master')

@section('content')
<div style="padding: 10px 20px; background-color: white; margin: 20px 0">
    <h1 style="margin-top: 0;">{{$book->title}}</h1>
    <div>
        @if($book->picture)
        <img src="{{asset('images/'.$book->picture->link)}}">
        @endif
        <h3>Description :</h3>
        <p style="padding: 10px 0">{{$book->description}}</p>
    </div>
    <h3>Auteur(s) :</h3>
    <ul>
        @forelse($book->authors as $author)
        <li>{{$author->name}}</li>
        @empty
        <li>Pas d'auteurs</li>
        @endforelse
    </ul>
</div>
@endsection