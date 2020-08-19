<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReferenciaController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        DB::table('registro_referencia')->insert(
            [
                'id_municipio' => $request->id_municipio, 
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
                'id_ips' => $request->id_ips,
                'id_municipio_rem' => $request->id_municipio_rem,
                'id_estado' => '1',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        return back()->with('success','Referencia creada satisfactoriamente.');
    }

    public function update(Request $request, $orden)
    {
        DB::table('registro_referencia')->insert(
            [
                'id_estado' => '2',
                'updated_at' => now()
            ]
        );

        return back()->with('success','Referencia actualizada satisfactoriamente.');
    }

    public function getPdf($orden)
    {
        
    }
}
