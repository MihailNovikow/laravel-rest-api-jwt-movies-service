<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
//use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Models\User;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
//use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\MovieResource;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class MovieController extends ApiController
{

public function getMovies() {
     try {
       $bearer = env('JWT_SECRET');

        $movies = Http::withToken($bearer)->get('https://the-one-api.dev/v2/movie')->json();
        $data = [];
 return response()->json(['data' => $movies]);

    } catch (NotFoundHttpException $e) {
        return response()->json([
                'message' => 'Record not found.'
            ], 404);
    }

}
    public function getMoviesInDB()
    {
$movies = Movie::all();
if($movies) {

return $this->respondSuccess($movies);
 } else {
           return $this->respondNotFound();
        }

    }
    public function getUnfavoriteMovies($loaderType, Request $request) {
        switch ($loaderType) {
            case 'sql':
              $movies = DB::raw($request->sql);
                break;
            case 'inMemory':
                $movies = DB::table('movies')->where('favorite', 'false')->get();
                break;
            default:
                return $this->respondUnprocessableEntity();
                break;
        }
        if($movies) {

return $this->respondSuccess($movies);
 } else {
           return $this->respondNotFound();
        }
    }
}
