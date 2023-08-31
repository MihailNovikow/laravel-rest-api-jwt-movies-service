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
use App\Services\MovieService;
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
$movieService = new MovieService;
 return $movieService->saveMovies();
    }
}
