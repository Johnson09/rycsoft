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
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        return redirect('/logout');
    }else{
        $id_usuario = $_SESSION['id_usuario'];
        $sw_encuesta = $_SESSION['sw_encuesta'];
        $sw_ryc = $_SESSION['sw_ryc'];
        $nombre_usuario = $_SESSION['nombre_usuario'];

        return view('indicadores.prueba', compact('id_usuario', 'sw_encuesta', 'sw_ryc', 'nombre_usuario'));
    }
});

Route::resource('/gestion_seguimiento', 'SeguimientoController');

Route::resource('/gestion_referencia', 'ReferenciaController');

Route::get('/get_referencia', 'ReferenciaController@getReferencia');

Route::get('/codeGeneration', 'ReferenciaController@codeGeneration');

Route::get('/codeValidation', 'ReferenciaController@codeValidation');

Route::get('/get_referencia_pdf/{orden}', 'ReferenciaController@getPdf');

Route::get('/send_email_referencia/{orden}', 'ReferenciaController@sendEmailReferencia')->name('send_email_referencia');

Route::get('/obtener_municipio', 'MunicipioController@getMunicipios');

Route::get('/obtener_municipio_ips', 'MunicipioController@getMunicipioIps');

Route::resource('/gestion_encuesta_covid', 'EncuestaCovidController');

Route::resource('/formulario_vih', 'FormularioVIHController');

Route::resource('/formulario_muestra', 'FormularioMuestraController');

Route::get('/obtener_paciente', 'PacienteController@getPaciente');

Route::get('/layout/{any}', 'RoutesController@index')->where('any', '.*');
