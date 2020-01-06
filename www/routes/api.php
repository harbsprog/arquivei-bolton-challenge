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

        /* Users Routes */
        Route::get("/users", "Users\UsersController@getAll");
        Route::get("/users/{id}", "Users\UsersController@get");
        Route::post("/users", "Users\UsersController@store");
        Route::put("/users/{id}", "Users\UsersController@update");
        Route::delete("/users/{id}", "Users\UsersController@destroy");
    }
);
