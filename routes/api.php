<?php

use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');

});
Route::group(['middleware' => 'auth:api'], function() {});
Route::get('/movie', [MovieController::class, 'index']);
Route::get('/savemovie', [MovieController::class, 'saveMovies']);
