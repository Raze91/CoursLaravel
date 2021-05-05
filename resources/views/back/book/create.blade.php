@extends('layouts.master')

@section('content')

<form action="{{route('book.store')}}" method="POST" enctype="multipart/form-data" >
    {{csrf_field()}}
    <div class="left">
        <h1>Create Book :</h1>

        <div class="input-ctnr">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" placeholder="Titre du livre" value="{{old('title')}}" />
            @if($errors->has('title'))
            <span class="error">{{$errors->first('title')}}</span>
            @endif
        </div>

        <div class="input-ctnr">
            <label for="description">Description :</label>
            <textarea name="description" id="description">{{old('description')}}</textarea>
            @if($errors->has('description'))
            <span class="error">{{$errors->first('description')}}</span>
            @endif
        </div>

        <div>
            <label>Genre :</label>
            <select id="genre" name="genre_id">
                <option value="0" {{ is_null(old( 'genre_id' )) ? 'selected' : '' }}>No genre</option>
                @foreach($genres as $id => $name)
                <option {{ old('genre_id') == $id ? 'selected' : '' }} value="{{$id}}">{{$name}}</option>
                @endforeach
            </select>
        </div>

        <h2>Choisissez un des acteurs :</h2>
        <div class="authors">
            @foreach($authors as $id => $name)
            <div>
                <label>{{$name}}
                    <input type="checkbox" name="authors[]" value="{{$id}}" id="author{{$id}}" {{ ( !empty(old('authors')) and in_array($id, old('authors')) )? 'checked' : '' }} />
                </label>
            </div>
            @endforeach
        </div>
    </div>

    <div class="right">
        <button type="submit">Ajouter un livre</button>

        <h2>Status</h2>
        <div>
            <label>
                <input type="radio" @if(old('status')=='published' ) checked @endif name="status" value="published" checked>
                Publié
            </label>
        </div>
        <div>
            <label>
                <input type="radio" @if(old('status')=='unpublished' ) checked @endif name="status" value="unpublished">
                Pas publié
            </label>
        </div>

        <div>
            <h2>File :</h2>
            <input type="file" name="picture" accept="image/png, image/jpeg" />
            @if($errors->has('picture')) <span class="error">{{$errors->first('picture')}}</span> @endif
        </div>
    </div>
</form>
@endsection

<style>
    form {
        display: flex;
    }

    select {
        width: fit-content;
    }

    .left {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 10px;
    }

    .right {
        flex: 1;
        padding: 10px;
    }

    button {
        background-color: cornflowerblue;
        border: none;
        border-radius: 4px;
        padding: 10px;
        margin: 20px 0 !important;
        color: white !important;
    }

    button a {
        color: white;
    }

    .authors {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .input-ctnr {
        display: flex;
        flex-direction: column;
        padding: 10px;
    }

    .error {
        color: red;
    }
</style>