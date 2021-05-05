<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Création des genres 
        App\Genre::create([
            "name" => "Science"
        ]);

        App\Genre::create([
            "name" => "Maths"
        ]);

        App\Genre::create([
            "name" => "Cookbook"
        ]);

        // on prendra garde de bien supprimer toutes les images avant de commencer les seeders
        Storage::disk('local')->delete(Storage::allFiles());

        // // création de 30 livres à partir de la factory
        factory(App\Book::class, 25)->create()->each(function ($book) {
            // associons un genre à un livre que nous venons de créer
            $genre = App\Genre::find(rand(1, 3));

            // pour chaque $book on lui associe un genre en particulier
            $book->genre()->associate($genre);
            $book->save(); // il faut sauvegarder l'association pour faire persister en base de données


            // ajout des images
            // On utilise futurama sur lorempicum pour récupérer des images aléatoirement
            // attention il n'y en a que 9 en tout différentes
            $link = str_random(12) . '.jpg'; // hash de lien pour la sécurité (injection de scripts protection)
            $file = file_get_contents('https://picsum.photos/300/'); // flux
            Storage::disk('local')->put($link, $file);

            $book->picture()->create([
                'title' => 'Default', // valeur par défaut
                'link' => $link
            ]);

            // récupération des id des auteurs à partir de la méthode pluck d'Eloquent
            // les méthodes du pluck shuffle et slice permettent de mélanger et récupérer un certain
            // nombre de 3 à partir de l'indice 0, comme ils sont mélangés à chaque fois qu'un livre est crée
            // La méthode all permet de faire la requête et de récupérer le résultat sous forme d'un tableau
            $authors = App\Author::pluck('id')->shuffle()->slice(0, rand(1, 3))->all();

            // Il faut se mettre maintenant en relation avec les auteurs (relation ManyToMany)
            // et attacher les id des auteurs dans la table de liaison.
            $book->authors()->attach($authors);
        });
    }
}
