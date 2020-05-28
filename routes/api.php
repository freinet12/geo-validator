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

Route::get('/states', 'StateController@index');
Route::post('/states', 'StateController@store');
Route::post('/states/createAll', 'StateController@createAll');
Route::post('/createGeoRecords', 'GeoController@store');
Route::get('/validateGeo', 'GeoController@validateGeo');

