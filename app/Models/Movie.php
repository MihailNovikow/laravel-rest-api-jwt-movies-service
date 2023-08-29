<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Aircraft;
use App\Models\FavoriteMovie;

class Movie extends Model
{
    use HasFactory;
    protected $table = 'movies';

    protected $fillable = [
   'name',
   'budgetInMillions',
   'favorite',
    ];
public function favoriteMovie()
    {
        return $this->hasMany(FavoriteMovie::class);
    }

}
