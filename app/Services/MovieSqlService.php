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
class MovieSqlService
{
public function getUnfavoriteMoviesBySql(Request $request) {

    try {
        $sql = $request->sql;
       $movies = DB::raw($sql);
 return response()->json(['message' => 'get unfavorite movies by sql successfully', 'sql' => $sql, 'UnfavoriteMovies' => $movies]);


    } catch (NotFoundHttpException $e) {
        return response()->json([
                'message' => 'Movies not found.'
            ], 404);
    }
}
}
