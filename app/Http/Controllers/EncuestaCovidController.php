<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EncuestaCovidController extends Controller
{
    public function index(){
        session_start();

        // dd($pagina);
        if (!isset($_SESSION['id'])) {
            return redirect('/logout');
        }else{
            $set = $_SESSION['id'];
            $name = $_SESSION['nombre'];

                // Datos requeridos encuesta covid
                $tipo_identificacion = DB::select("SELECT * FROM tipo_identificacion ");
                $regimen_eps = DB::select("SELECT * FROM entidad_eps ");
                $genero = DB::select("SELECT * FROM tipo_sexo ");
                $servicio = DB::select("SELECT * FROM tipo_servicio ");
                $tipo_usuario = DB::select("SELECT * FROM tipo_ambulancia ");

                date_default_timezone_set('America/Bogota');
                $date = date("Y-m-d");
    
                return view('encuestas.covid', 
                            compact(    
                                'set', 
                                'name', 
                                'tipo_identificacion', 
                                'regimen_eps', 
                                'genero', 
                                'servicio', 
                                'tipo_usuario',
                                'date',
                            ));

        }

    }
}
