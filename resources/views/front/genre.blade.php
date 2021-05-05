@extends('layouts.master')

@section('content')
<div style="text-align: center;">
    <h1>Livres de {{$genre->name}} :</h1>
    {{$books->links()}}
</div>
@forelse($books as $book)
<div style="padding: 20px; background-color: white; margin: 20px 0">
    <h2 style="margin-top: 0;"><a href="{{url('book', $book->id)}}">{{$book->title}}</a></h2>
    <div style="display: flex">
        @if($book->picture)
        <img src="{{asset('images/'.$book->picture->link)}}">
        @endif
        <p style="padding: 0 10px">{{$book->description}}</p>
    </div>
    <h3>Auteur(s) :</h3>
    <ul>
        @forelse($book->authors as $author)
        <li><a href="{{url('author', $author->id)}}">{{$author->name}}</a></li>
        @empty
        <li>Pas d'auteurs</li>
        @endforelse
    </ul>
</div>
@empty
<h2>Désolée pour l'instant aucun livre n'est publié sur le site</h2>
@endforelse
<div style="text-align: center;">
    {{$books->links()}}
</div>
@endsection