<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\UsuarioData;
use App\RolesUsuarios;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
class UsuariosController extends Controller
{
    public function cambiar_password () {
        $data['titulo_pagina'] = 'Usuario - Cambiar contraseña';
        return view('home.usuarios.password_change', $data);
    }
    public function datatables (Request $request) {

                $all = UsuarioData::with(['user'])
                        ->select('*', 'users.name as cuenta_usuario')
                        ->join('users', 'users_data.du_id', '=', 'users.id')
                        ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                        ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id');
                        // ->leftJoin('despacho_cilindros', 'despacho_cilindros.despacho_id', '=', 'despacho.des_id')
                        // ->getAllByProceso($code)->selectRaw('distinct despacho.*, entidades.nombre');

                $make = DataTables::of($all)
                        ->filter( function ($query) use ($request) {
                            if ($request->has('buscar')) {
                                if (request('buscar') != '') {
                                    $query->where( function( $query ) use($request) {
                                        // $query->where('doc_numero', 'like', "%{$request->buscar}%");
                                        $query->orWhere('users_data.nombres', 'like', "%{$request->buscar}%");
                                        $query->orWhere('users_data.apellidos', 'like', "%{$request->buscar}%");
                                        // $query->orWhere('despacho_cilindros.cilindro_codigo', 'like', "%{$request->buscar}%");
                                        // $query->orWhere('entidades.nombre', 'like', "%{$request->buscar}%");
                                        // $query->orWhere('apellidos', 'like', "%{$request->buscar}%");
                                    });
                                    // $query->operador()->where
                                }


                                // $query->orWhere('numero_lote', 'like', "%{$custom['query']}%");
                                // $query->orWhere('cilindro', 'like', "%{$custom['query']}%");
                            }

                            // if ($request->has('filtro_date') && $request->has('desde') && $request->has('hasta')) {
                            //     if ($request->filtro_date == 'interval') {
                            //         $query->where('fecha_emision', '>=', $request->desde);
                            //         $query->where('fecha_emision', '<=', $request->hasta);
                            //     }
                            //     if ($request->filtro_date == 'same') {
                            //         $query->where('fecha_emision', '=', $request->desde);
                            //     }
                            // }
                        });
                        // ->editColumn('doc_numero', '{{ fill_zeros($doc_numero) }}');
                return $make->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['titulo_pagina'] = 'Usuario - Listar';
        return view('home.usuarios.listar', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['titulo_pagina'] = 'Usuario - Crear';
        return view('home.usuarios.registro', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'cuenta' => 'required'
        ]);
        $res = ['success' => false];
        DB::transaction(function () use($request, &$res) {
            $new = new Usuario();
            $new->name = $request->cuenta;
            $new->email = $request->cuenta;
            $new->password = password_hash("123456", PASSWORD_DEFAULT);
            if ($new->save()) {
                $new_data = new UsuarioData();
                $new_data->nombres = $request->nombre;
                $new_data->apellidos = $request->apellidos;
                $new_data->direccion = $request->direccion;
                $new_data->telefono = $request->telefono;
                $new_data->dni = $request->dni;
                $new_data->users_id = $new->id;
                if ($new_data->save()) {
                    $role = new RolesUsuarios();
                    $role->role_id = $request->tipo;
                    $role->user_id = $new->id;
                    $role->save();
                    $res['success'] = true;
                }
            }
        });
        return response()->json($res);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'modo' => 'required',
        ]);
        switch ($request->modo) {
            case 'cambiar_password':
                $row = Usuario::find($id);
                if ($row) {
                    if (password_verify($request->old_pass, $row->password)) {
                        $row->password = password_hash($request->new_pass, PASSWORD_DEFAULT);
                        $row->save();
                        $request->session()->flash('error_login', true);
                        $request->session()->flash('error_msg', 'Contraseña actualizada');
                        return redirect('home/usuarios/cambiar_password');
                    } else {
                        $request->session()->flash('error_login', true);
                        $request->session()->flash('error_msg', 'Contraseña incorrecta');
                        return redirect('home/usuarios/cambiar_password');
                    }

                }

                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
