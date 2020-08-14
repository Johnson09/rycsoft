<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    public function getMunicipios(Request $request){

        $id_departamento = $request->input('id_dept');

        $municipio = DB::select("SELECT * FROM municipios WHERE id_departamento = '$id_departamento'");
            
        return response()->json($municipio);
    }
}
