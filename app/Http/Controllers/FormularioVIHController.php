<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FormularioVIHController extends Controller
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

                // Datos requeridos encuesta covid
                $tipo_identificacion = DB::select("SELECT * FROM tipo_identificacion ");
                $regimen_eps = DB::select("SELECT * FROM entidad_eps ");
                $genero = DB::select("SELECT * FROM tipo_sexo ");
                $servicio = DB::select("SELECT * FROM tipo_servicio ");
                $tipo_usuario = DB::select("SELECT * FROM tipo_usuario ");
                $preguntas = DB::select("SELECT * 
                                        FROM preguntas_encuesta AS pe
                                        INNER JOIN grupos_preguntas AS gp ON pe.id_pregunta = gp.id_pregunta ");
                $encuesta = DB::select("SELECT ti.name_tipo_ident, p.id_paciente, p.primer_nombre,
                                        p.segundo_nombre, p.primer_apellido, p.segundo_apellido, 
                                        date_part('year',age(CURRENT_DATE,p.fecha_nacimiento)) AS edad, 
                                        ts.name_sexo, p.direccion, p.telefono, p.email, ee.name_eps,
                                        tu.descripcion_tipo_user, tsc.name_servicio, re.created_at 
                                        FROM registro_encuesta AS re
                                        INNER JOIN pacientes AS p ON re.id_paciente = p.id_paciente
                                        INNER JOIN tipo_identificacion AS ti ON p.id_tipo_ident = ti.id_tipo_ident
                                        INNER JOIN tipo_usuario AS tu ON re.id_tipo_user = tu.id_tipo_user
                                        INNER JOIN tipo_sexo AS ts ON p.id_sexo = ts.id_sexo
                                        INNER JOIN tipo_servicio AS tsc ON re.id_servicio = tsc.id_servicio
                                        INNER JOIN entidad_eps AS ee ON re.id_eps = ee.id_eps ");
                // dd($preguntas);

                date_default_timezone_set('America/Bogota');
                $date = date("Y-m-d");
    
                return view('formularios.vih', 
                            compact(    
                                'id_usuario',
                                'sw_encuesta',
                                'sw_ryc',
                                'nombre_usuario',
                                'tipo_identificacion', 
                                'regimen_eps', 
                                'genero', 
                                'servicio', 
                                'tipo_usuario',
                                'preguntas',
                                'encuesta',
                                'date',
                            ));

        }

    }
}
