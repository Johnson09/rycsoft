<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function getPaciente(Request $request){

        $id_paciente = $request->input('id_paciente');
        $paciente = DB::select("SELECT * FROM pacientes WHERE id_paciente = '$id_paciente'");
            
        return response()->json($paciente);
    }
}
