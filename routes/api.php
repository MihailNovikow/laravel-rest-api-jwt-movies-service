<?php

use App\Http\Controllers\Api\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\Api\FavoriteMovieController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');

});

//Route::group(['middleware' => 'auth:api'], function($router) {
    Route::controller(AuthUserController::class)->group(function () {
    Route::get('profile/{user_id}', 'showAuthUser');
    Route::patch('profile/{user_id}/update', 'updateAuthUser');
    Route::delete('profile/{user_id}/delete', 'deleteAuthUser');
//});
});
//Вывод всех сохраненных в базе фильмов с постраничной навигацией
Route::get('/movies', [MovieController::class, 'getMoviesInDB']);

Route::post('/savemovie', [MovieController::class, 'saveMovies']);
// добавление фильмов в избранное.
Route::post('/add_movie_to_favorites', [FavoriteMovieController::class, 'store']);
//удаление фильмов из избранного
Route::delete('/remove_movie_from_favorites', [FavoriteMovieController::class, 'destroy']);

/*отдельный эндпоинт для вывода всех фильмов, которых у пользователя нет в избранном. В запросе должен передаваться query параметр loaderType. Должно быть реализовано 2 сервиса по поиску фильмов которых нет в избранном:
С использованием SQL запроса для выборки
(loaderType=sql)

В памяти приложения. Загрузить список всех фильмов и список избранных фильмов пользователя, и среди всех найти те, которых нет в избранном
(loaderType=inMemory)*/
Route::get('/unfavorite_movies/{loaderType}', [MovieController::class, 'getUnfavoriteMovies']);
