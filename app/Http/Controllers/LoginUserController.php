<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginUserController extends Controller
{
    //
	public function logout (Request $request) {
		$request->session()->flush();
		return redirect('login');
	}
	public function show_login (Request $request) {
		return view('login');
	}
	public function inciar_session (Request $request) {
		// dd($request);
		// redirect('home');
		if ($request->has('btn_login')) {
			if (Usuario::existe_usuario($request->usuario)) {
				$usuario = Usuario::get_usuario_account($request->usuario, $request->password);
				// dd(DB::getQueryLog());
				if ($usuario && password_verify($request->password, $usuario->password)) {
					$request->session()->put('usuario_autenticado', true);
					$request->session()->put('usuario_data', $usuario);
					return redirect('home');
				}
			} else {
				$request->session()->flash('error_login', true);
				$request->session()->flash('error_msg', 'Usuario y/o contraseña incorrectos');
				return redirect('login');
			}
		}
		return redirect('login');

	}
}
