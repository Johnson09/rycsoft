<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReferenciaController extends Controller
{
    public function store(Request $request)
    {
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
        $request->validate([
            'id_producto' => 'required',
            'cod_barras' => 'required',
            'id_grupo' => 'required',
            'id_clase' => 'required',
            'id_subclase' => 'required',
            'descripcion' => 'required',
            'id_und_med' => 'required',
            'id_proveedor' => 'required',
            'id_marca' => 'required',
            'sw_iva' => 'required',
            'und_venta' => 'required',
            'cant_und_venta' => 'required',
        ]);
  
        // Producto::create($request->all());
   
        return redirect('home')
                        ->with('success','Referencia actualizada satisfactoriamente.');
    }
}
