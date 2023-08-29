<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class FavoriteMovie extends Model
{
    use HasFactory;
     protected $fillable = [
   'movie_id',
   'user_id'
    ];
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function user() {
         return $this->belongsTo(User::class);
    }
}
