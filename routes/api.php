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



// Rutas para /cliente
Route::get('/cliente', 'ClientesController@index');
Route::get('/cliente/{hashId}', 'ClientesController@show');
Route::post('/cliente', 'ClientesController@store');
Route::patch('/cliente/{hashId}', 'ClientesController@update');
Route::delete('/cliente/{hashId}', 'ClientesController@destroy');

// Rutas para /estatus
Route::resource('estatus', 'EstatusController', ['except' => [
	'create', 'edit'
]]);

// Rutas para /marca
Route::resource('marca', 'MarcasController', ['except' => [
	'create', 'edit'
]]);
