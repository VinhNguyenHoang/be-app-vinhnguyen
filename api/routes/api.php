<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth'
], function() {
    Route::post('login', 'Auth\AuthController@login');

    Route::group([
        'middleware' => 'auth.jwt',
    ], function () {
        // Route::get('logout', 'Auth\AuthController@logout');
        // Route::get('me', 'Auth\AuthController@me');
    });
});

// enable throttle:api to prevent spamming from incoming requests (allows 60 requests per minute)
Route::middleware(['throttle:api'])->post('register', 'RegisterController@storeRegister');

Route::get('user-by-event/{event_id}', 'UserController@showUserByEvent');
Route::delete('user', 'UserController@deleteUser');