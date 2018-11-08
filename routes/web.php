<?php

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

Route::get('home', 'HomeController@index');
Route::get('home/news', 'HomeController@news');
Route::get('home/botellas', 'HomeController@botellas');
Route::get('home/propietarios/', 'HomeController@propietarios');

Route::get('home/recursos/sistemas', 'RecursosController@sistemas');
Route::get('home/recursos/negocios', 'RecursosController@negocios');

// Route::get('home/cilindros/', 'HomeController@cilindros_listar');//listar
// Route::get('home/cilindros/registro', 'HomeController@cilindros_registro');//registrar
// Route::get('home/cilindros/{id}/editar', 'HomeController@cilindros_registro');//editar

// Route::get('propietarios/listar', 'PropietariosController@listar');
// Route::post('propietarios/agregar', 'PropietariosController@agregar');


Route::get('home/propietarios/deben', 'PropietariosController@deben');



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
