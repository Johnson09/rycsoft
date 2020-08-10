<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){
        session_start();
        $set = $_SESSION['id'];
        $name = $_SESSION['nombre'];
        return view('layout.app', compact('set', 'name'));
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
