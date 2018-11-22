<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('propietarios/agregar', 'PropietariosController@agregar');
// Route::put('propietarios/actualizar', 'PropietariosController@actualizar');
Route::get('propietarios/listar', 'PropietariosController@listar');
// Route::get('propietarios/{id}', 'PropietariosController@getdata');
// Route::prefix('pro')->middleware('propietarios')
//     ->group(function () {
//         Route::post('agregar', 'PropietariosController@agregar');
//     });

Route::post('login_usuario', 'LoginUserController@inciar_session');

Route::resource ('propietarios', 'PropietariosController');
Route::resource ('cilindro', 'CilindroController')->only([
    'store', 'update', 'destroy', 'show', 'index'
]);
Route::resource ('produccion', 'ProduccionController')->only([
    'store', 'update', 'destroy'
]);
Route::resource ('despacho', 'DespachoController')->only([
    'store', 'update', 'destroy'
]);
Route::resource ('recibo', 'ReciboController')->only([
    'store', 'update', 'destroy'
]);
Route::resource ('usuarios', 'UsuariosController')->only([
    'store', 'update', 'destroy'
]);
Route::resource ('documentos_identidad', 'DocumentosIdentidadController');
// Route::group(['middleware' => 'web'], function () {
//   // Route::post('propietarios/agregar', 'PropietariosController@agregar');
// })

