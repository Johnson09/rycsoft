<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrinaUrucultivosController extends Controller
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
                $genero = DB::select("SELECT * FROM tipo_sexo ");
                $consentimiento = DB::select("SELECT ti.name_tipo_ident, p.id_paciente, p.primer_nombre,
                                        p.segundo_nombre, p.primer_apellido, p.segundo_apellido, 
                                        date_part('year',age(CURRENT_DATE,p.fecha_nacimiento)) AS edad, 
                                        ts.name_sexo, p.direccion, p.telefono, p.email, re.created_at,
                                        re.firma_consultante, re.firma_responsable  
                                        FROM registro_consentimiento_vih AS re
                                        INNER JOIN pacientes AS p ON re.id_paciente = p.id_paciente
                                        INNER JOIN tipo_identificacion AS ti ON p.id_tipo_ident = ti.id_tipo_ident
                                        INNER JOIN tipo_sexo AS ts ON p.id_sexo = ts.id_sexo ");
                // dd($consentimiento);

                date_default_timezone_set('America/Bogota');
                $date = date("Y-m-d");
    
                return view('formularios.orinaurucultivos', 
                            compact(    
                                'id_usuario',
                                'sw_encuesta',
                                'sw_ryc',
                                'nombre_usuario',
                                'tipo_identificacion', 
                                'genero', 
                                'consentimiento',
                                'date',
                            ));

        }

    }
}
