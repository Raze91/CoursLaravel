<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book; // importez l'alias de la classe
use App\Author;
use App\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FrontController extends Controller
{
    public function __construct()
    {
        // méthode pour injecter des données à une vue partielle
        view()->composer('partials.menu', function ($view) {
            $genres = Genre::pluck('name', 'id')->all(); // on récupère un tableau associatif ['id' => 1]
            $view->with('genres', $genres); // on passe les données à la vue
        });
    }

    public function index()
    {
            $books = Book::published()->with('picture', 'authors')->paginate(8); // retourne tous les livres de l'application
        

        return view('front.index', ['books' => $books]);
    }

    public function show(int $id)
    {

        return view('front.show', ['book' => Book::find($id)]);
    }

    public function showByAuthor(int $id)
    {

        $books = Author::find($id)->books()->paginate(5);

        return view("front.author", ['books' => $books, 'author' => Author::find($id)]);
    }

    public function showGenres(int $id)
    {

        $books = Genre::find($id)->books()->paginate(5);

        return view('front.genre', ['books' => $books, 'genre' => Genre::find($id)]);
    }
}
