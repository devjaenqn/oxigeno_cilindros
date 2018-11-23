<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('template');
    return redirect('home/news');
});

Route::middleware(['autenticado'])->group(function() {

	Route::get('home', 'HomeController@index');
	Route::get('home/news', 'HomeController@news');
	Route::get('home/botellas', 'HomeController@botellas');

	foreach (['datatables', 'deben', 'balance'] as $key => $value) {
		Route::get('home/propietarios/'.$value, 'PropietariosController@'.$value);
	}

	Route::get('home/propietarios/', 'HomeController@propietarios');


	Route::get('home/recursos/sistemas', 'RecursosController@sistemas');
	Route::get('home/recursos/negocios', 'RecursosController@negocios');

	// Route::get('home/cilindros/', 'HomeController@cilindros_listar');//listar
	// Route::get('home/cilindros/registro', 'HomeController@cilindros_registro');//registrar
	// Route::get('home/cilindros/{id}/editar', 'HomeController@cilindros_registro');//editar

	// Route::get('propietarios/listar', 'PropietariosController@listar');
	// Route::post('propietarios/agregar', 'PropietariosController@agregar');


	//alternative api
	Route::resource('home/cilindro', 'CilindroController')->only([
	    'index', 'create', 'show', 'edit'
	]);
	Route::get('home/cilindro/{id}/{modo}', 'CilindroController@show');
	Route::resource('home/produccion', 'ProduccionController')->only([
	    'index', 'create', 'show', 'edit'
	]);
	Route::resource('home/despacho', 'DespachoController')->only([
	    'index', 'create', 'show', 'edit'
	]);
	Route::resource('home/recibo', 'ReciboController')->only([
	    'index', 'create', 'show', 'edit'
	]);
	Route::get('test', 'HomeController@test');


	foreach (['datatables', 'cambiar_password'] as $key => $value) {
		Route::get('home/usuarios/'.$value, 'UsuariosController@'.$value);
	}
	Route::resource('home/usuarios', 'UsuariosController')->only([
	    'index', 'create', 'show', 'edit'
	]);



	Route::get('logout', 'LoginUserController@logout');

});



// Route::get('login', 'LoginUserController@show_login');
// Route::get('login', 'LoginUserController@show_login')->middleware();
Route::get('login', function(Request $request) {
	if ($request->session()->has('usuario_autenticado')) {
    if ($request->session()->get('usuario_autenticado') == true)
        return redirect('home');
  }
  return view('login');
})->middleware();

// Route::get('login_usuario', 'LoginUserController@inciar_session');







