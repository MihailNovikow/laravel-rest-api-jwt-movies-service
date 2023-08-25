<?php

namespace App\Jobs;

use App\Http\Controllers\Api\MovieController;
use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
class MoviesPagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*Раз в 3 часа собирать 3 страницы фильмов из /movie
Сохранять name и budgetInMillions
В базе не должно быть повторяющихся фильмов
 */
    try {
        $bearer = env('JWT_SECRET');

        $movies = Http::withToken($bearer)->get('http://the-one-api.dev/v2/movie');
        $data = [];
        foreach ($movies as $key => $item) {
             $data['id'] = $item->id;
             $data['name'] = $item->name;
             $data['budgetInMillions'] = $item->budgetInMillions;
             return saveMovie($data[$key]);
            }
            function saveMovie(Request $request) {
                $validatedData = $request->validate([
    'name' => ['required', 'unique:movie'],
    'budgetInMillions' => ['required', 'unique:movie'],
]);
$savedMovies = Movie::create($validatedData);
 return response()->json(['data' => $savedMovies, 'message' => 'movies saved successfully']);
            }


    } catch (NotFoundHttpException $e) {
        return response()->json([
                'message' => 'Record not found.'
            ], 404);
    }

    }
}
