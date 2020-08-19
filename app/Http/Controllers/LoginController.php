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
                $empresa = DB::select("SELECT * FROM empresas ");
                dd($empresa);
                $date = date("Y-m-d");
    
                // Datos de llenado tabla de referencia
                $referencias = DB::select('SELECT r.id_orden, d.name_departamento, m.name_municipio, 
                                    tr.name_regimen, r.first_lastname, r.second_lastname, 
                                    r.first_name, r.second_name, ti.alias_tipo_ident, r.identification_number,
                                    ee.name_eps, r.birthday, ts.alias_sexo, td.id_diagnostico, td.name_diagnostico,
                                    tse.alias_servicio, ei.name_ips, tse.name_servicio, 
                                    mu.name_municipio as municipio_rem, r.created_at, r.updated_at 
                                    FROM registro_referencia AS r 
                                    INNER JOIN municipios AS m ON r.id_municipio = m.id_municipio 
                                    INNER JOIN departamentos AS d ON m.id_departamento = d.id_departamento 
                                    INNER JOIN tipo_regimen AS tr ON r.id_regimen = tr.id_regimen
                                    INNER JOIN tipo_identificacion AS ti ON r.id_tipo_ident = ti.id_tipo_ident
                                    INNER JOIN entidad_eps AS ee ON r.id_eps = ee.id_eps 
                                    INNER JOIN tipo_sexo AS ts ON r.id_sexo = ts.id_sexo 
                                    INNER JOIN tipo_diagnostico AS td ON r.id_diagnostico = td.id_diagnostico
                                    INNER JOIN tipo_servicio AS tse ON r.id_servicio = tse.id_servicio 
                                    INNER JOIN entidad_ips AS ei ON r.id_ips = ei.id_ips
                                    INNER JOIN municipios AS mu ON r.id_municipio_rem = mu.id_municipio');

                // dd($referencias);
    
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
                                'empresa',
                                'date',
                                'referencias'
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
