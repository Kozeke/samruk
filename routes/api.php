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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {

    // token = $2y$10$ffqT92SWHABx2ulBdscBy.b12bUTw6mauBQ.q2RvtB47nnmRBtLyW
    Route::get('get-news/{token}', 'NewsController@getNews')->where('token', '(.*)');
    Route::post('get-langs', 'LangsController@getLangs');

});
