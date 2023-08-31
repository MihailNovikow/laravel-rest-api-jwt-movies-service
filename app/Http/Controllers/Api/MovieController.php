<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use App\Models\User;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use App\Jobs\MoviesPagesJob;
use App\Services\MovieSqlService;
use App\Services\MovieInMemoryService;
use Illuminate\Support\Facades\Http;

class MovieController extends ApiController
{
public function saveMovies() {
    MoviesPagesJob::dispatch();
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
              $movieService = new MovieSqlService;
    return $movieService->getUnfavoriteMoviesBySql($request);
                break;
            case 'inMemory':
                $movieService = new MovieInMemoryService();
    return $movieService->getUnfavoriteMoviesInMemory();
                break;
            default:
                return $this->respondUnprocessableEntity();
                break;
        }
    }
}
