<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(
    function () {
        Route::post('login', 'AuthController@authenticate');
        Route::post('register', 'AuthController@register');
    }
);

Route::group(
    ['middleware' => 'auth.jwt'],
    function () {

        /* NFes Routes */
        Route::get('/nfe/{access_key}', ['uses' => 'Nfes\NfeController@getByAccessKey']);
        Route::get('/nfe/{id}', ['uses' => 'Nfes\NfeController@get']);
        Route::post('/nfe', ['uses' => 'Nfes\NfeController@store']);
        Route::put('/nfe/{access_key}', ['uses' => 'Nfes\NfeController@update']);
        Route::delete('/nfe/{access_key}', ['uses' => 'Nfes\NfeController@destroy']);

        /* Users Routes */
        Route::get("/users",  ['uses' => "Users\UsersController@getAll"]);
        Route::get("/users/{id}",  ['uses' => "Users\UsersController@get"]);
        Route::post("/users",  ['uses' => "Users\UsersController@store"]);
        Route::put("/users/{id}",  ['uses' => "Users\UsersController@update"]);
        Route::delete("/users/{id}",  ['uses' => "Users\UsersController@destroy"]);
    }
);
