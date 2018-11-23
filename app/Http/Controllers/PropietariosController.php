<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropietariosResource;
use App\Propietarios;
use App\PropietariosLocacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PropietariosController extends Controller
{
  public function datatables (Request $request) {
    $all = Propietarios::select('*')->join('documentos_identidad', 'entidades.tipo_doc', 'documentos_identidad.cod');

    $make = DataTables::of($all)
            ->filter( function ($query) use ($request) {
                if ($request->has('buscar')) {
                    if (request('buscar') != '') {
                        $query->where( function( $query ) use($request) {

                            $query->orWhere('entidades.nombre', 'like', "%{$request->buscar}%");
                            $query->orWhere('entidades.numero', 'like', "%{$request->buscar}%");

                        });
                    }
                }
            });
    return $make->make(true);
  }
  public function deben () {
    return view('home.propietarios.deben');
  }
    public function listar () {
      $propietarios =  Propietarios::all();
      $propietarios->makeVisible(['telefono']);
      return  response()->json(PropietariosResource::collection($propietarios));
    }

    public function index (Request $request) {

      if ($request->filled('q')) {
        $res = [];
        $res = Propietarios::select('ent_id', 'nombre', 'numero')
          ->where('nombre', 'like', '%'.request('q').'%')
          ->orWhere('numero', 'like', '%'.request('q').'%')
          ->get();
        // dd($res[0]->documento);
        return response()->json($res);
      }

      if ($request->filled('qq')) {
        $res = [];
        $res = Propietarios::select('ent_id', 'nombre', 'numero', 'direccion', 'tipo_doc')
          ->where('nombre', 'like', '%'.request('qq').'%')
          ->orWhere('numero', 'like', '%'.request('qq').'%')
          ->get();
        // dd($res[0]->documento);
        return response()->json(PropietariosResource::collection($res->makeVisible(['direccion'])));
      }
    }

    public function show ($id) {
      $res = ['success' => false];
      $cod_res = 204;
      $data =  new PropietariosResource(Propietarios::find($id));
      if ($data != null) {
        $res['success'] = true;
        $res['data'] = $data;
        $cod_res = 200;
      }
      return  response()->json($res, $cod_res);
    }

    public function store (Request $request) {
      if (request('documento') != 0) {
        $valida = $request->validate([
          'nombre' => 'required',
          'numero' => 'required',
          'documento' => 'required',
          // 'password' => 'required|min:6'
        ]);
      } else {
        $valida = $request->validate([
          'nombre' => 'required',
          'documento' => 'required',
          // 'password' => 'required|min:6'
        ]);
      }

      // $this->validate($request, );
      $res = ['success' => false];
      $success = true;
      // if (request('documento') == 6) {
      if (request('documento') != 0) {
        if (request('numero') != '0000') {
          // $pro = Propietarios::where('numero', request('numero'))
          //         ->where('tipo_doc', request('documento'))
          //         ->get()->first();
          $pro = Propietarios::existe(request('numero'), request('documento'));
          $success = $pro == null;
        }
      }
        // $res['temp'] = $pro;
        if ($success) {
          DB::transaction(function () use (&$res) {
            $propietario = Propietarios::create([
              'tipo_doc' => request('documento'),
              'numero' => request('numero'),
              'nombre' => request('nombre'),
              'direccion' => request('direccion', ''),
              'telefono' => request('telefono', ''),
              'referencia' => request('referencia', ''),
              'correo' => request('correo', ''),
            ]);
            if (trim(request('direccion')) != '') {
              //insertar locación por defecto
              $locacion = new PropietariosLocacion();
              $locacion->entidad_id = $propietario->ent_id;
              $locacion->locacion = request('direccion');
              $locacion->predeterminado = '1';
              $locacion->save();
            }

            $res['success'] = $propietario != null;
            $res['data'] = $propietario;
          });
          return response()->json($res);
        } else {
          return response()->json($res, 422);
        }
      // }


    }

    public function update (Request $request, $id) {
      $valida = $request->validate([
        'nombre' => 'required',
        'numero' => 'required',
        // 'password' => 'required|min:6'
      ]);
      // $this->validate($request, );

      $res = ['success' => false];

      $propietario = Propietarios::find($id);
      $res['success'] = $propietario != null;
      $success = true;

      if (request('documento') != 0) {
        if (request('numero') != '0000') {
          $pro = Propietarios::existe(request('numero'), request('documento'));
          $success = $pro == null;
        }
      }
      if ($propietario && $success) {
        $propietario->tipo_doc = request('documento');
        $propietario->nombre = request('nombre');
        $propietario->numero = request('numero');
        $propietario->direccion = request('direccion', '');
        $propietario->telefono = request('telefono', '');
        $propietario->referencia = request('referencia', '');
        $propietario->correo = request('correo', '');
        $propietario->save();
      }

      $res['data'] = $propietario;
      return response()->json($res);
    }

}
