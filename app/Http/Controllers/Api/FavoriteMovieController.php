<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\FavoriteMovie;
use Illuminate\Http\Request;
use App\Models\Movie;

class FavoriteMovieController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //жадная загрузка
    $movies = Movie::withCount('favorite')->get();
    if($movies) {
        return response()->json([
            'status' => 'success',
            'movies' => $movies,
        ]);
    } else {
             return $this->respondNotFound();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //update movie and create favoriteMovie


          $movie = Movie::find($request->movie_id);
          if($movie) {
             $movie['favorite'] = 1;
             $movie->save();
          }
           $user = auth('api')->user();
          $favoriteMovie = new FavoriteMovie();
          $favoriteMovie['user_id'] = $user->id;
           $favoriteMovie['movie_id'] = $request->movie_id;
        $favoriteMovie = FavoriteMovie::create($request);
        
          if($movie && $favoriteMovie) {
            return response()->json([
                'message'=> 'success',
                'movie' => $movie,
                'favorite_movie' => $favoriteMovie
            ]);
    } else {
             return $this->respondNotFound();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FavoriteMovie  $favoriteMovie
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavoriteMovie $favoriteMovie, Request $request)
    {
          $movie = Movie::findOrFail($request->movie_id);
          
        $favoriteMovie = FavoriteMovie::findOrFail($request->favoriteMovie_id);
          if($movie && $favoriteMovie) {
$movie->favoriteMovie()->delete();
            return response()->json([
                'message'=> 'success',
                'movie' => $movie,
                'favoriteMovie' => $favoriteMovie
            ]);
    } else {
             return $this->respondNotFound();
        }
    }
}
