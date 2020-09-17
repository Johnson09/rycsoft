<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::resource('/login', 'LoginController');

Route::get('/home', 'LoginController@index');

Route::get('/logout', function () {
    session_start();
    session_destroy();
    return view('welcome');
});

Route::get('/prueba', function () {
    $name = "prueba";
    return view('indicadores.prueba', compact('name'));
});

Route::get('/gestion_seguimiento', function () {
    $name = "prueba";
    return view('directivas.seguimiento', compact('name'));
});

Route::resource('/gestion_referencia', 'ReferenciaController');

Route::get('/get_referencia', 'ReferenciaController@getReferencia');

Route::get('/codeGeneration', 'ReferenciaController@codeGeneration');

Route::get('/codeValidation', 'ReferenciaController@codeValidation');

Route::get('/get_referencia_pdf/{orden}', 'ReferenciaController@getPdf');

Route::get('/obtener_municipio', 'MunicipioController@getMunicipios');

Route::get('/obtener_municipio_ips', 'MunicipioController@getMunicipioIps');

Route::resource('/gestion_encuesta_covid', 'EncuestaCovidController');

Route::get('/layout/{any}', 'RoutesController@index')->where('any', '.*');
