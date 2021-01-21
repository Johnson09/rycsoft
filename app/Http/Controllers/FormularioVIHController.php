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
    
                return view('formularios.vih', 
                            compact(
                                'id_usuario',
                                'sw_encuesta',
                                'sw_ryc',
                                'nombre_usuario',
                                'tipo_identificacion', 
                                'genero', 
                                'consentimiento',
                                'date'
                            )
                        );

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
                    'fecha_registro' => now()
                ]
            );
        }

        $img1 = str_replace('data:image/png;base64,', '', $request->firma_consultante);
        $fileData1 = base64_decode($img1);
        $fileName1 = uniqid().'.png';

        file_put_contents('public/firms_image/'.$fileName1, $fileData1);

        $img2 = str_replace('data:image/png;base64,', '', $request->firma_responsable);
        $fileData2 = base64_decode($img2);
        $fileName2 = uniqid().'.png';

        file_put_contents('public/firms_image/'.$fileName2, $fileData2);
        
        $registro_consentimiento = DB::select("SELECT nextval('registro_consentimiento_vih_id_registro_consentimiento_vih_seq'); ");
        $id_registro_consentimiento_vih = $registro_consentimiento[0]->nextval;
        // // dd($id_registro_encuesta);

        DB::table('registro_consentimiento_vih')->insert(
            [ 
                'id_registro_consentimiento_vih' => $id_registro_consentimiento_vih,
                'id_paciente' => $request->identification_number,
                'firma_consultante' => $fileName1, 
                'firma_responsable' => $fileName2,
                'sw_terminos' => $request->terminos, 
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        return back()->with('success','Consentimiento registrado satisfactoriamente.');
    }
}
