<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SeguimientoController extends Controller
{
    public function index(){
        session_start();

        // dd($pagina);
        if (!isset($_SESSION['id_usuario'])) {
            return redirect('/logout');
        }else{
            $id_usuario = $_SESSION['id_usuario'];
            $sw_encuesta = $_SESSION['sw_encuesta'];
            $sw_ryc = $_SESSION['sw_ryc'];
            $nombre_usuario = $_SESSION['nombre_usuario'];

                // Datos requeridos en los formularios de referencia
                $tipo_identificacion = DB::select("SELECT * FROM tipo_identificacion ");
                $regimen_eps = DB::select("SELECT * FROM entidad_eps ");
                $genero = DB::select("SELECT * FROM tipo_sexo ");
                $servicio = DB::select("SELECT * FROM tipo_servicio ");
                $regimen_ips = DB::select("SELECT * FROM entidad_ips ");
                $municipio_remitente = DB::select("SELECT * FROM municipios ");
                $egreso = DB::select("SELECT * FROM vias_egreso ");

                date_default_timezone_set('America/Bogota');
                $date = date("Y-m-d");
    
                // Datos de llenado tabla de seguimiento
                $seguimiento = array();
    
                return view('directivas.seguimiento', 
                            compact(    
                                'id_usuario',
                                'sw_encuesta',
                                'sw_ryc',
                                'nombre_usuario', 
                                'tipo_identificacion', 
                                'regimen_eps', 
                                'genero', 
                                'servicio', 
                                'regimen_ips', 
                                'municipio_remitente',
                                'date',
                                'egreso',
                                'seguimiento'
                            ));

        }

    }
}
