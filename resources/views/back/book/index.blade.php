@extends('layouts.master')

@section('content')
<div style="display: flex; flex-direction: column; width: fit-content;">
    <button><a href="{{route('book.create')}}">Ajouter un livre</a></button>
    {{$books->links()}}
    @include('back.book.partials.flash')
</div>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Authors</th>
            <th>Genre</th>
            <th>Date de publication</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Show</th>
            <th>Delete</th>
        </tr>
    </thead>

    <tbody>
        @foreach($books as $book)
        <tr>
            <td><a href="{{route('book.edit', $book->id)}}">{{$book->title}}</a></td>
            <td>
                @foreach($book->authors as $author)
                {{$author->name}}
                @endforeach
            </td>
            <td>{{$book->genre->name}}</td>
            <td>{{$book->created_at}}</td>
            <td>
                @if($book->status == 'published')
                <span class="published">Publié</span>
                @else
                <span class="unpublished">Pas publié</span>
                @endif
            </td>
            <td><a href="{{route('book.edit', $book->id)}}">Edit</a></td>
            <td><a href="{{route('book.show', $book->id)}}">Show</a></td>
            <td>
                <form class="deleteForm" action="{{ route('book.destroy', $book->id)}}" method="POST" style='margin: 0'>
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <button class="delete" type="submit">DELETE</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('scripts')
@parent
<script src="{{asset('js/confirm.js')}}"></script>
@endsection

<style>
    table {
        width: 100%;
    }

    tr>th,
    tr>td {
        padding: 10px;
    }

    thead,
    tr>td {
        border-bottom: solid 1px gray;
    }

    button {
        background-color: dodgerblue;
        border: none;
        border-radius: 4px;
        padding: 8px;
    }

    button:hover {
        background-color: cornflowerblue;
    }

    button a {
        color: white;
    }

    button a:hover {
        color: white;
        text-decoration: none;
    }

    .delete {
        background-color: crimson;
        display: block;
        color: white;
    }

    .delete:hover {
        background-color: brown;
    }

    .published {
        background-color: forestgreen;
        padding: 8px;
        color: white;
    }

    .unpublished {
        background-color: darkgoldenrod;
        padding: 8px;
        color: white;
    }
</style>