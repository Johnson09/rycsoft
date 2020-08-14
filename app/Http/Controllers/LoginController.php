<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request){
        session_start();

        // dd($pagina);
        if (!isset($_SESSION['id'])) {
            return redirect('/logout');
        }else{
            $set = $_SESSION['id'];
            $name = $_SESSION['nombre'];
    
            $pagina = '';
            $pagina = $request->input('p');
            if ($pagina == 'referencia') {

                // Datos requeridos en los formularios de referencia
                $departamento = DB::select("SELECT * FROM departamentos ");
                $regimen = DB::select("SELECT * FROM tipo_regimen ");
                $tipo_identificacion = DB::select("SELECT * FROM tipo_identificacion ");
                $regimen_eps = DB::select("SELECT * FROM entidad_eps ");
                $genero = DB::select("SELECT * FROM tipo_sexo ");
                $diagnostico = DB::select("SELECT * FROM tipo_diagnostico ");
                $servicio = DB::select("SELECT * FROM tipo_servicio ");
                $regimen_ips = DB::select("SELECT * FROM entidad_ips ");
                $municipio_remitente = DB::select("SELECT * FROM municipios ");
                $date = date("Y-m-d");
    
                // Datos de llenado tabla de referencia
                $referencias = '';
    
                return view('layout.app', 
                            compact(    
                                'set', 
                                'name', 
                                'departamento', 
                                'regimen', 
                                'tipo_identificacion', 
                                'regimen_eps', 
                                'genero', 
                                'diagnostico', 
                                'servicio', 
                                'regimen_ips', 
                                'municipio_remitente',
                                'date'
                            ));
            }else{
                return view('layout.app', compact('set', 'name'));
            }
        }

    }

    public function store(Request $request)
    {
        $usuario = $request->get('usuario');
        $password = $request->get('contraseña');

        $query = DB::select("SELECT us.id_user, us.name_user FROM system_users us WHERE us.usern = '$usuario' and us.password = md5('$password')");

        session_start();

        if ($query == null && empty($query)) {
            return redirect('/')->with('status', 'Usuario o Contraseña incorrecta!');
        }else{
            foreach ($query as $key => $value){
                $_SESSION['id'] = $value->id_user;
                $_SESSION['nombre'] = $value->name_user;
                $set = $value->id_user;
                $name = $value->name_user;
            }

            return redirect('/home');
        }
    }
}
