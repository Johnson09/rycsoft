<?php

namespace App\Http\Controllers;

use PDF;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReferenciaController extends Controller
{
    public function index(){
        session_start();

        // dd($pagina);
        if (!isset($_SESSION['id'])) {
            return redirect('/logout');
        }else{
            $set = $_SESSION['id'];
            $name = $_SESSION['nombre'];

                // Datos requeridos en los formularios de referencia
                $regimen = DB::select("SELECT * FROM tipo_regimen ");
                $tipo_identificacion = DB::select("SELECT * FROM tipo_identificacion ");
                $regimen_eps = DB::select("SELECT * FROM entidad_eps ");
                $genero = DB::select("SELECT * FROM tipo_sexo ");
                $diagnostico = DB::select("SELECT * FROM tipo_diagnostico ");
                $servicio = DB::select("SELECT * FROM tipo_servicio ");
                $regimen_ips = DB::select("SELECT * FROM entidad_ips ");
                $municipio_remitente = DB::select("SELECT * FROM municipios ");
                $empresa = DB::select("SELECT * FROM empresas ");
                $estado = DB::select("SELECT * FROM estados ");
                $servicio_sol = DB::select("SELECT * FROM tipos_servicios_sol ");
                $origen = DB::select("SELECT * FROM origenes_atencion ");
                $ubicacion = DB::select("SELECT * FROM ubicacion_paciente ");
                $atencion = DB::select("SELECT * FROM prioridad_atencion ");
                $ambulancia = DB::select("SELECT * FROM tipo_ambulancia ");
                $cup = DB::select("SELECT * FROM cups ");

                date_default_timezone_set('America/Bogota');
                $date = date("Y-m-d");
    
                // Datos de llenado tabla de referencia
                $referencias = DB::select("SELECT r.id_orden, tr.name_regimen, e.nit_empresa, e.cod_hab_empresa,  
                                    ti.alias_tipo_ident, r.id_paciente, ts.alias_sexo, p.primer_apellido,
                                    p.segundo_apellido, p.primer_nombre, p.segundo_nombre, 
                                    ee.name_eps, td.id_diagnostico, tse.alias_servicio, ei.name_ips,
                                    tse.name_servicio, r.name_doctor, p.fecha_nacimiento, 
                                    date_part('year',age(CURRENT_DATE,p.fecha_nacimiento)) AS edad,
                                    es.id_estado, date_part('day',age(now(),r.updated_at)) AS espera_dias, 
                                    r.cod_apro, mu.name_municipio as municipio_rem, r.created_at, 
                                    r.updated_at, es.descripcion  
                                    FROM registro_referencia AS r 
                                    INNER JOIN tipo_regimen AS tr ON r.id_regimen = tr.id_regimen
                                    INNER JOIN empresas AS e ON r.id_empresa = e.id_empresa 
                                    INNER JOIN pacientes AS p ON r.id_paciente = p.id_paciente
                                    INNER JOIN tipo_identificacion AS ti ON p.id_tipo_ident = ti.id_tipo_ident
                                    INNER JOIN entidad_eps AS ee ON r.id_eps = ee.id_eps 
                                    INNER JOIN tipo_sexo AS ts ON p.id_sexo = ts.id_sexo 
                                    INNER JOIN tipo_diagnostico AS td ON r.id_diagnostico = td.id_diagnostico
                                    INNER JOIN tipo_servicio AS tse ON r.id_servicio = tse.id_servicio 
                                    LEFT JOIN entidad_ips AS ei ON r.id_ips = ei.id_ips
                                    LEFT JOIN municipios AS mu ON ei.id_municipio = mu.id_municipio
                                    INNER JOIN estados AS es ON r.id_estado = es.id_estado
                                    LEFT JOIN tipo_ambulancia AS ta ON r.id_ambulancia = ta.id_ambulancia");

                // dd($referencias);
    
                return view('directivas.referencia', 
                            compact(    
                                'set', 
                                'name', 
                                'regimen', 
                                'tipo_identificacion', 
                                'regimen_eps', 
                                'genero', 
                                'diagnostico', 
                                'servicio', 
                                'regimen_ips', 
                                'municipio_remitente',
                                'empresa',
                                'estado',
                                'ambulancia',
                                'origen',
                                'ubicacion',
                                'servicio_sol',
                                'atencion',
                                'cup',
                                'date',
                                'referencias'
                            ));

        }

    }

    public function store(Request $request)
    {
        // dd($request);
        session_start();
        $id_user = $_SESSION['id'];

        $documento1 = '';
        $documento2 = '';
        $documento3 = '';
        $documento4 = '';

        for ($i=1; $i < 5; $i++) { 
            if (isset($_FILES['uploadedFile'.$i]) && $_FILES['uploadedFile'.$i]['error'] === UPLOAD_ERR_OK) {
                // get details of the uploaded file
                $fileTmpPath = $_FILES['uploadedFile'.$i]['tmp_name'];
                $fileName = $_FILES['uploadedFile'.$i]['name'];
                $fileSize = $_FILES['uploadedFile'.$i]['size'];
                $fileType = $_FILES['uploadedFile'.$i]['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

                if(isset($_FILES['uploadedFile1'])){
                    $documento1 = $newFileName;
                }elseif (isset($_FILES['uploadedFile2'])) {
                    $documento2 = $newFileName;
                }elseif (isset($_FILES['uploadedFile3'])) {
                    $documento3 = $newFileName;
                }elseif (isset($_FILES['uploadedFile4'])) {
                    $documento4 = $newFileName;
                }

                $allowedfileExtensions = array('jpg', 'pdf', 'png');

                if (in_array($fileExtension, $allowedfileExtensions)) {
                    // directory in which the uploaded file will be moved
                    $uploadFileDir = './public/uploaded_files/';
                    $dest_path = $uploadFileDir . $newFileName;
                    
                    move_uploaded_file($fileTmpPath, $dest_path);
                }
            }
        }

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
                'telefono' => $request->telefono,
                'email' => $request->email,
                'fecha_registro' => now(),
                'id_municipio' => $request->id_municipio_paciente
            ]
        );

        DB::table('registro_referencia')->insert(
            [
                'id_regimen' => $request->id_regimen, 
                'id_user' => $id_user, 
                'id_empresa' => $request->id_empresa, 
                'id_tipo_ident' => $request->id_tipo_ident,
                'id_paciente' => $request->identification_number,
                'id_eps' => $request->id_eps,
                'id_diagnostico' => $request->id_diagnostico,
                'name_doctor' => $request->name_doctor,
                'id_servicio' => $request->id_servicio,
                'id_estado' => '1',
                'doc_rem_soft_inst' => $documento1,
                'doc_resul_lab' => $documento2,
                'doc_resul_rx' => $documento3,
                'doc_ficha_epi' => $documento4,
                'id_diagnostico_1' => $request->id_diagnostico_1,
                'id_diagnostico_2' => $request->id_diagnostico_2,
                'id_diagnostico_3' => $request->id_diagnostico_3,
                'justificacion_clinica' => $request->justificacion_clinica,
                'id_origen_atencion' => $request->id_origen_atencion,
                'id_prioridad_atencion' => $request->id_prioridad_atencion,
                'id_tipo_servicio_sol' => $request->id_tipo_servicio_sol,
                'id_ubicacion_pte' => $request->id_ubicacion_pte,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        return back()->with('success','Referencia creada satisfactoriamente.');
    }

    public function update(Request $request, $orden)
    {
        $codigo = '';
        $estado = $request->id_estado;

        if ($estado = 2) {
            $codigo = substr(md5(time()), 0, 20);
        }

        DB::table('registro_referencia')
            ->where('id_orden', $orden)
            ->update(
                [
                    'id_ips' => $request->id_ips,
                    'id_municipio_rem' => $request->id_municipio_rem,
                    'id_estado' => $request->id_estado,
                    'cod_apro' => $codigo,
                    'id_ambulancia' => $request->id_ambulancia,
                    'cod_autorizacion' => $request->cod_autorizacion,
                    'updated_at' => now()
                ]
            );

        return back()->with('success','Referencia actualizada satisfactoriamente.');
    }

    public function codeGeneration(Request $request)
    {
        $id_orden = $request->input('id_orden');

        $codigo = substr(md5(time()), 0, 10);

        DB::table('registro_referencia')
            ->where('id_orden', $id_orden)
            ->update(
                [
                    'cod_apro' => $codigo
                ]
            );

        return response()->json($codigo);
    }

    public function codeValidation(Request $request)
    {
        $codigo = $request->input('codigo');

        $referencia = DB::select("SELECT * FROM registro_referencia WHERE cod_apro = '$codigo'");

        $output = ['result' => $referencia];

        return response()->json($output);
    }

    public function getReferencia(Request $request)
    {
        $id_orden = $request->input('id_orden');

        $referencia = DB::select("SELECT d.name_departamento, m.name_municipio, 
                                    tr.name_regimen, e.nombre_empresa, p.primer_apellido, p.segundo_apellido, 
                                    p.primer_nombre, p.segundo_nombre, ti.name_tipo_ident, p.id_paciente,
                                    ee.name_eps, p.fecha_nacimiento, ts.name_sexo, td.name_diagnostico,
                                    tse.name_servicio, tse.name_servicio, r.name_doctor, r.id_estado  
                                    FROM registro_referencia AS r 
                                    INNER JOIN tipo_regimen AS tr ON r.id_regimen = tr.id_regimen
                                    INNER JOIN empresas AS e ON r.id_empresa = e.id_empresa
                                    INNER JOIN municipios AS m ON e.id_municipio = m.id_municipio 
                                    INNER JOIN departamentos AS d ON m.id_departamento = d.id_departamento 
                                    INNER JOIN pacientes AS p ON r.id_paciente = p.id_paciente
                                    INNER JOIN tipo_identificacion AS ti ON p.id_tipo_ident = ti.id_tipo_ident
                                    INNER JOIN entidad_eps AS ee ON r.id_eps = ee.id_eps 
                                    INNER JOIN tipo_sexo AS ts ON p.id_sexo = ts.id_sexo 
                                    INNER JOIN tipo_diagnostico AS td ON r.id_diagnostico = td.id_diagnostico
                                    INNER JOIN tipo_servicio AS tse ON r.id_servicio = tse.id_servicio 
                                    INNER JOIN estados AS es ON r.id_estado = es.id_estado
                                    WHERE r.id_orden = '$id_orden'");

        return response()->json($referencia);
    }

    public function getPdf($orden)
    {
        // Generador de pdf
        ini_set('max_execution_time', 300);

        $referencia = DB::select("SELECT d.name_departamento, m.name_municipio, tp1.name_diagnostico AS dr1,
                                    tp2.name_diagnostico AS dr2, tp3.name_diagnostico AS dr3, tss.descripcion_servicio_sol, 
                                    pa.descripcion_prioridad, oa.descripcion_origen, up.descripcion_ubicacion, 
                                    dp.name_departamento AS dep_paciente, mp.name_municipio AS mun_paciente, 
                                    tr.name_regimen, e.nombre_empresa, p.primer_apellido, p.segundo_apellido, 
                                    p.primer_nombre, p.segundo_nombre, ti.name_tipo_ident, r.id_paciente, 
                                    p.direccion AS dir_paciente, p.telefono AS tel_paciente, p.email, 
                                    ee.name_eps, p.fecha_nacimiento, ts.name_sexo, td.name_diagnostico, 
                                    td.id_diagnostico, tp1.id_diagnostico AS cr1, tp2.id_diagnostico AS cr2, tp3.id_diagnostico AS cr3,
                                    tse.name_servicio, tse.name_servicio, r.name_doctor, r.id_estado, 
                                    ei.name_ips, mu.name_municipio AS municipio_rem, r.created_at, 
                                    e.nit_empresa, e.cod_hab_empresa, e.direccion, e.telefono 
                                    FROM registro_referencia AS r 
                                    INNER JOIN tipo_regimen AS tr ON r.id_regimen = tr.id_regimen
                                    INNER JOIN empresas AS e ON r.id_empresa = e.id_empresa
                                    INNER JOIN municipios AS m ON e.id_municipio = m.id_municipio 
                                    INNER JOIN departamentos AS d ON m.id_departamento = d.id_departamento 
                                    INNER JOIN pacientes AS p ON r.id_paciente = p.id_paciente
                                    INNER JOIN municipios AS mp ON p.id_municipio = mp.id_municipio 
                                    INNER JOIN departamentos AS dp ON mp.id_departamento = dp.id_departamento 
                                    INNER JOIN tipo_identificacion AS ti ON p.id_tipo_ident = ti.id_tipo_ident
                                    INNER JOIN entidad_eps AS ee ON r.id_eps = ee.id_eps 
                                    INNER JOIN tipo_sexo AS ts ON p.id_sexo = ts.id_sexo 
                                    INNER JOIN tipo_diagnostico AS td ON r.id_diagnostico = td.id_diagnostico
                                    INNER JOIN tipo_servicio AS tse ON r.id_servicio = tse.id_servicio 
                                    LEFT JOIN entidad_ips AS ei ON r.id_ips = ei.id_ips
                                    LEFT JOIN municipios AS mu ON ei.id_municipio = mu.id_municipio
                                    INNER JOIN estados AS es ON r.id_estado = es.id_estado
                                    LEFT JOIN tipo_ambulancia AS ta ON r.id_ambulancia = ta.id_ambulancia
                                    INNER JOIN tipo_diagnostico AS tp1 ON r.id_diagnostico_1 = tp1.id_diagnostico
                                    INNER JOIN tipo_diagnostico AS tp2 ON r.id_diagnostico_2 = tp2.id_diagnostico
                                    INNER JOIN tipo_diagnostico AS tp3 ON r.id_diagnostico_3 = tp3.id_diagnostico
                                    INNER JOIN prioridad_atencion AS pa ON r.id_prioridad_atencion = pa.id_prioridad_atencion
                                    INNER JOIN origenes_atencion AS oa ON r.id_origen_atencion = oa.id_origen_atencion
                                    INNER JOIN ubicacion_paciente AS up ON r.id_ubicacion_pte = up.id_ubicacion_pte
                                    INNER JOIN tipos_servicios_sol AS tss ON r.id_tipo_servicio_sol = tss.id_tipo_servicio_sol
                                    WHERE r.id_orden = '$orden'");

        $cadena = $referencia[0]->created_at;
        $array = explode(" ", $cadena);
        // dd($array);
        
        $text = 'Referencia_numero_'.$orden.'.pdf';

        $pdf = \PDF::loadView('pdf.pdf_referencia', compact('referencia','orden','text','array'));
        //dd($pdf); 

        // $pdf->setPaper('A4', 'landscape'); // Formato de la hoja

        // Se genera o se returna el pdf de la cotizacion
        return $pdf->stream($text);
    }
}
