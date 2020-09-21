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
                $preguntas = DB::select("SELECT * FROM preguntas_encuesta ORDER BY id_pregunta ASC ");
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
                                'date',
                            ));

        }

    }

    public function store(Request $request)
    {
        // dd($request);

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

        DB::table('registro_encuesta')->insert(
            [ 
                'id_paciente' => $request->identification_number,
                'id_tipo_user' => $request->tipo_usuario,
                'id_eps' => $request->id_eps, 
                'id_servicio' => $request->id_servcio,
                'id_pregunta' => $request->id_pregunta, 
                'respuesta_pregunta' => $request->rid_pregunta, 
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return back()->with('success','Encuesta registrada satisfactoriamente.');
    }
}
