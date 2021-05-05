<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'description', 'genre_id', 'status'
    ];

    public function scopePublished($query){
        return $query->where('status', 'published');
    }

    public function setGenreAttribute($value) {
        if($value == 0) {
            $this->attributes['genre_id'] = "Pas de genre";
        } else {
            $this->attributes['genre_id'] = $value;
        }
    }

    public function genre() {
        return $this->belongsTo(Genre::class);
    }

    public function authors() {
        return $this->belongsToMany(Author::class);
    }

    public function picture() {
        return $this->hasOne(Picture::class);
    }
}
