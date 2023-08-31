<?php

namespace App\Services;
use App\Models\Movie;
use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
//use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Support\Facades\Validator;
class MovieService
{
public function saveMovies() {
       try {
       $bearer = env('JWT_SECRET');

        $movies = Http::withToken($bearer)->get('https://the-one-api.dev/v2/movie')->json();
        $moviesArray = $movies['docs'];
        $moviesInDB = Movie::all();
        $data = [];
      foreach ($moviesArray as $key=>$item) {
if( $item['name'] !== null &&  $item['budgetInMillions'] !== null) {
  $data[$key]['name'] = $item['name'];
  $data[$key]['budgetInMillions'] = $item['budgetInMillions'];

$validatorMovies = Validator::make($data[$key], [
    'name' => 'required|unique:movies|string',
    'budgetInMillions' => 'required',
]);
if($validatorMovies->fails()) {
    return response()->json(['message' => 'фильм с этим названием уже существует']);
}
$savedMovies[] = Movie::create($data[$key]);
}
}

 return response()->json(['message' => 'movies saved successfully', 'saved' => $savedMovies, 'inDB' => $moviesInDB]);


    } catch (NotFoundHttpException $e) {
        return response()->json([
                'message' => 'Record not found.'
            ], 404);
    }
}
}
