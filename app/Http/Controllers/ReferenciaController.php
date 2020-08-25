<?php

namespace App\Http\Controllers;

use PDF;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReferenciaController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
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

        DB::table('registro_referencia')->insert(
            [
                'id_regimen' => $request->id_regimen, 
                'id_user' => $request->id_user, 
                'id_empresa' => $request->id_empresa, 
                'first_lastname' => $request->first_lastname, 
                'second_lastname' => $request->second_lastname, 
                'first_name' => $request->first_name, 
                'second_name' => $request->second_name,
                'id_tipo_ident' => $request->id_tipo_ident,
                'identification_number' => $request->identification_number,
                'id_eps' => $request->id_eps,
                'birthday' => $request->birthday,
                'id_sexo' => $request->id_sexo,
                'id_diagnostico' => $request->id_diagnostico,
                'name_doctor' => $request->name_doctor,
                'id_servicio' => $request->id_servicio,
                'id_estado' => '1',
                'doc_rem_soft_inst' => $documento1,
                'doc_resul_lab' => $documento2,
                'doc_resul_rx' => $documento3,
                'doc_ficha_epi' => $documento4,
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
                                    tr.name_regimen, e.nombre_empresa, r.first_lastname, r.second_lastname, 
                                    r.first_name, r.second_name, ti.name_tipo_ident, r.identification_number,
                                    ee.name_eps, r.birthday, ts.name_sexo, td.name_diagnostico,
                                    tse.name_servicio, tse.name_servicio, r.name_doctor, r.id_estado  
                                    FROM registro_referencia AS r 
                                    INNER JOIN tipo_regimen AS tr ON r.id_regimen = tr.id_regimen
                                    INNER JOIN empresas AS e ON r.id_empresa = e.id_empresa
                                    INNER JOIN municipios AS m ON e.id_municipio = m.id_municipio 
                                    INNER JOIN departamentos AS d ON m.id_departamento = d.id_departamento 
                                    INNER JOIN tipo_identificacion AS ti ON r.id_tipo_ident = ti.id_tipo_ident
                                    INNER JOIN entidad_eps AS ee ON r.id_eps = ee.id_eps 
                                    INNER JOIN tipo_sexo AS ts ON r.id_sexo = ts.id_sexo 
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

        $referencia = DB::select("SELECT d.name_departamento, m.name_municipio, 
                                    tr.name_regimen, e.nombre_empresa, r.first_lastname, r.second_lastname, 
                                    r.first_name, r.second_name, ti.name_tipo_ident, r.identification_number,
                                    ee.name_eps, r.birthday, ts.name_sexo, td.name_diagnostico,
                                    tse.name_servicio, tse.name_servicio, r.name_doctor, r.id_estado, 
                                    ei.name_ips, mu.name_municipio AS municipio_rem   
                                    FROM registro_referencia AS r 
                                    INNER JOIN tipo_regimen AS tr ON r.id_regimen = tr.id_regimen
                                    INNER JOIN empresas AS e ON r.id_empresa = e.id_empresa
                                    INNER JOIN municipios AS m ON e.id_municipio = m.id_municipio 
                                    INNER JOIN departamentos AS d ON m.id_departamento = d.id_departamento 
                                    INNER JOIN tipo_identificacion AS ti ON r.id_tipo_ident = ti.id_tipo_ident
                                    INNER JOIN entidad_eps AS ee ON r.id_eps = ee.id_eps 
                                    INNER JOIN tipo_sexo AS ts ON r.id_sexo = ts.id_sexo 
                                    INNER JOIN tipo_diagnostico AS td ON r.id_diagnostico = td.id_diagnostico
                                    INNER JOIN tipo_servicio AS tse ON r.id_servicio = tse.id_servicio 
                                    LEFT JOIN entidad_ips AS ei ON r.id_ips = ei.id_ips
                                    INNER JOIN municipios AS mu ON ei.id_municipio = mu.id_municipio
                                    INNER JOIN estados AS es ON r.id_estado = es.id_estado
                                    LEFT JOIN tipo_ambulancia AS ta ON r.id_ambulancia = ta.id_ambulancia
                                    WHERE r.id_orden = '$orden'");
        
        $text = 'Referencia_numero_'.$orden.'.pdf';

        $pdf = \PDF::loadView('pdf.pdf_referencia', compact('referencia','orden','text'));
        //dd($pdf); 

        // $pdf->setPaper('A4', 'landscape'); // Formato de la hoja

        // Se genera o se returna el pdf de la cotizacion
        return $pdf->stream($text);
    }
}
