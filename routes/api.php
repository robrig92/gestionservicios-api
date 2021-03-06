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
Route::get('/cliente/parcial/{pagina}', 'ClientesController@parcial');
Route::post('/cliente', 'ClientesController@store');
Route::patch('/cliente/{hashId}', 'ClientesController@update');
Route::delete('/cliente/{hashId}', 'ClientesController@destroy');

// Rutas para /usuario
Route::get('/usuario', 'UsuariosController@index');
Route::get('/usuario/{hashId}', 'UsuariosController@show');
Route::get('/usuario/parcial/{pagina}', 'UsuariosController@parcial');
Route::delete('/usuario/{hashId}', 'UsuariosController@destroy');

// Rutas para /estatus
Route::resource('estatus', 'EstatusController', ['except' => [
	'create', 'edit'
]]);

// Rutas para /marca
Route::resource('marca', 'MarcasController', ['except' => [
	'create', 'edit'
]]);

// Rutas para /notificacion
Route::resource('notificacion', 'NotificacionesController', ['except' => [
	'create', 'edit'
]]);

// Rutas para /permiso
Route::resource('permiso', 'PermisosController', ['except' => [
	'create', 'edit'
]]);

// Rutas para prioridad
Route::resource('prioridad', 'PrioridadController', ['except' => [
	'create', 'edit'
]]);

// Rutas para rol
Route::resource('rol', 'RolesController', ['except' => [
	'create', 'edit'
]]);

// Rutas para servicio
Route::resource('servicio', 'ServiciosController', ['except' => [
	'create', 'edit'
]]);
