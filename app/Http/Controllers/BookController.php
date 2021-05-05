<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(8);

        return view('back.book.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // permet de récupérer une collection type array avec en clé id => name
        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.create', ['authors' => $authors, 'genres' => $genres]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors' => 'array',
            'authors.*' => 'integer',
            'status' => 'in:published,unpublished',
            'picture' => 'image|max:3000'
        ]);

        $book = Book::create($request->all());

        $book->authors()->attach($request->authors);

        $im = $request->file('picture');

        if(!empty($im)) {
            // méthode store retourne un link hash sécurisé
            $link = $request->file('picture')->store('/');
    
            $book->picture()->create([
                'link' => $link,
                'title' => $request->title_image ?? $request->title
            ]);
        }

        return redirect()->route('book.index')->with('message', 'Livre créé avec succés !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('back.book.show', ['book' => Book::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);
        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors' => 'array',
            'authors.*' => 'integer',
            'status' => 'in:published,unpublished',
            'picture' => 'image|max:3000'
        ]);

        $book = Book::find($id);

        $book->update($request->all());

        $book->authors()->sync($request->authors);

        $im = $request->file('picture');

        // si on associe une image à un book 
        if (!empty($im)) {

            $link = $request->file('picture')->store('/');

            // suppression de l'image si elle existe 
            if ($book->picture) {
                Storage::disk('local')->delete($book->picture->link); // supprimer physiquement l'image
                $book->picture()->delete(); // supprimer l'information en base de données
            }

            // mettre à jour la table picture pour le lien vers l'image dans la base de données
            $book->picture()->create([
                'link' => $link,
                'title' => $request->title_image ?? $request->title
            ]);
        }


        return redirect()->route('book.index')->with('message', 'Livre mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        // suppression de l'image si elle existe 
        if ($book->picture) {
            Storage::disk('local')->delete($book->picture->link); // supprimer physiquement l'image
            $book->picture()->delete(); // supprimer l'information en base de données
        }
        $book->delete();
        return redirect()->route('book.index')->with('message', 'Livre supprimé avec succés !');
    }
}
