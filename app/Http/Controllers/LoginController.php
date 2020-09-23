<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        session_start();

        // dd($pagina);
        if (!isset($_SESSION['id_usuario'])) {
            return redirect('/logout');
        }else{
            $id_usuario = $_SESSION['id_usuario'];
            $sw_encuesta = $_SESSION['sw_encuesta'];
            $nombre_usuario = $_SESSION['nombre_usuario'];

            return view('inicio.home', compact('id_usuario', 'sw_encuesta', 'nombre_usuario'));
        }

    }

    public function store(Request $request)
    {
        $usuario = $request->get('usuario');
        $password = $request->get('contraseña');

        $query = DB::select("SELECT us.id_user, up.sw_encuesta, us.name_user 
                            FROM system_users AS us 
                            INNER JOIN usuarios_perfiles AS up ON us.id_user = up.id_user
                            WHERE us.usern = '$usuario' and us.password = md5('$password')");

        session_start();

        if ($query == null && empty($query)) {
            return redirect('/')->with('status', 'Usuario o Contraseña incorrecta!');
        }else{
            foreach ($query as $key => $value){
                $_SESSION['id_usuario'] = $value->id_user;
                $_SESSION['sw_encuesta'] = $value->sw_encuesta;
                $_SESSION['nombre_usuario'] = $value->name_user;
            }

            return redirect('/home');
        }
    }
}
