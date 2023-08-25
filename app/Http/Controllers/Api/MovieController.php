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

public function saveMovies() {
     try {
        $bearer = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c';//env('JWT_SECRET');

        $movies = Http::withToken($bearer)->get('https://the-one-api.dev/v2/movie')->json();
        $data = [];
      /*  foreach ($movies as $key => $item) {
            // $data['id'] = $item->id;
           //  $data['name'] = $item->name;
            // $data['budgetInMillions'] = $item->budgetInMillions;
             return saveMovie($movies);//($data[$key]);
            }*/
           /* function saveMovie($movies//Request $request
            ) {    $validatedData = $request->validate([
    'name' => ['required', 'unique:movie'],
    'budgetInMillions' => ['required', 'unique:movie'],
]);*/
//$savedMovies = Movie::create($movies);
 return response()->json(['data' => $movies]);//, 'message' => 'movies saved successfully'
         //   }


    } catch (NotFoundHttpException $e) {
        return response()->json([
                'message' => 'Record not found.'
            ], 404);
    }

}
    public function index(Request $request)
    {
$movies = Movie::all()->paginate(10);
/*$client = new Client([

            'headers' => [
                'content-type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer $bearer",
                ],
            ]);
             $response = $client->request('GET', 'http://the-one-api.dev/v2/movie');
      $data = $response->getBody();
if(!$data) {
        return $this->respondNotFound();
    }
//$movies = $moviesInDb !== [] ? $moviesInDb : $data;
$movies = $data;
*/



  if($movies) {

return $this->respondSuccess($movies);
 } else {
           return $this->respondNotFound();
        }

    }
    public function addToFavourites() {

    }
    public function removeFromFavourites() {

    }
    public function getNotFavourites($loaderType, Request $request) {
        switch ($loaderType) {
            case 'sql':
              $movies = DB::raw($request->sql);
                break;
            case 'inMemory':
                $movies = DB::table('movies')->where('favourite', 'false')->get();
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
       /* if($loaderType='sql') {
              $movies = DB::raw($request->sql);//DB::table('movies')->sql($request->sql)->get();
        }
        if($loaderType='inMemory') {
           $movies = DB::table('movies')->where('favourite', 'false')->get();
        }
        else {

        }*/
    }
}
