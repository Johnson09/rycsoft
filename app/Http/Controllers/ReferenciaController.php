<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReferenciaController extends Controller
{
    public function store(Request $request)
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
                        ->with('success','Referencia registrada satisfactoriamente.');
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
