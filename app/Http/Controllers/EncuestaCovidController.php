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
                $tipo_usuario = DB::select("SELECT * FROM tipo_usuario ");
                $preguntas = DB::select("SELECT * 
                                        FROM preguntas_encuesta AS pe
                                        INNER JOIN grupos_preguntas AS gp ON pe.id_pregunta = gp.id_pregunta ");
                $encuesta = DB::select("SELECT ti.name_tipo_ident, p.id_paciente, p.primer_nombre,
                                        p.segundo_nombre, p.primer_apellido, p.segundo_apellido, 
                                        date_part('year',age(CURRENT_DATE,p.fecha_nacimiento)) AS edad, 
                                        ts.name_sexo, p.direccion, p.telefono, p.email, ee.name_eps,
                                        tu.descripcion_tipo_user, tsc.name_servicio 
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
    
                return view('encuestas.covid', 
                            compact(    
                                'set', 
                                'name', 
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

    public function store(Request $request)
    {
        // dd($request);
        $existencia = DB::select("SELECT * FROM pacientes WHERE id_paciente = '$request->identification_number' ");
        // dd(count($existencia));
        if (count($existencia) == 0) {
            DB::table('pacientes')->insert(
                [ 
                    'id_paciente' => $request->identification_number,
                    'id_tipo_ident' => $request->id_tipo_ident,
                    'primer_nombre' => $request->first_name, 
                    'segundo_nombre' => $request->second_name,
                    'primer_apellido' => $request->first_lastname, 
                    'segundo_apellido' => $request->second_lastname, 
                    'fecha_nacimiento' => $request->birthday,
                    'id_sexo' => $request->id_sexo,
                    'direccion' => $request->address,
                    'telefono' => $request->telephone,
                    'email' => $request->email,
                    'fecha_registro' => now()
                ]
            );
        }
        
        $registro_encuesta = DB::select("SELECT nextval('registro_encuesta_id_registro_encuesta_seq'); ");
        $id_registro_encuesta = $registro_encuesta[0]->nextval;
        // // dd($id_registro_encuesta);

        DB::table('registro_encuesta')->insert(
            [ 
                'id_registro_encuesta' => $id_registro_encuesta,
                'id_paciente' => $request->identification_number,
                'id_tipo_user' => $request->tipo_usuario,
                'id_eps' => $request->id_eps, 
                'id_servicio' => $request->id_servicio,
                'terminosycondiciones' => $request->terminos, 
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        for ($i=1; $i < 37; $i++) { 
            DB::table('registro_encuesta_preguntas')->insert(
                [ 
                    'id_registro_encuesta' => $id_registro_encuesta,
                    'id_pregunta' => $_REQUEST['id_pregunta'.$i], 
                    'respuesta_pregunta' => $_REQUEST['respuesta_pregunta'.$i], 
                    'observacion_pregunta' => $_REQUEST['observacion_pregunta'.$i], 
                    'fecha_registro' => now()
                ]
            );
        }

        return back()->with('success','Encuesta registrada satisfactoriamente.');
    }
}
