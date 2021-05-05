<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// // retourne l'ensemble des books
// Route::get('books', function () {
//     return App\Book::all();
// });



// // plusieurs paramètres
// Route::get('search/{word1}/{word2}', function (string $word1, string $word2) {
//     $search = $word1 . " " . $word2; // espace entre les mots pour un titre
//     // like avec % permet de faire une recherche pour des mots
//     // qui contiennent une chaîne de caractères donnée
//     // cette requête est équivalente à :
//     // SELECT * FROM books WHERE title like '%quelquechose%'
//     $result = App\Book::where('title', 'like', "%$search%")
//         ->get();
//     if (count($result) == 0) {
//         return "sorry not found";
//     }
//     return $result;
// });

Route::get('/', 'FrontController@index');

// retourne une ressource en fonction de son id
Route::get('book/{id}', 'FrontController@show')->where(['id' => '[0-9]+']);

Route::get('author/{id}', 'FrontController@showByAuthor')->where(['id' => '[0-9]+']);

Route::get('genre/{id}', 'FrontController@showGenres')->where(['id' => '[0-9]+']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('admin/book', 'BookController')->middleware('auth');
