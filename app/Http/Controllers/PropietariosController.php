<?php

namespace App\Http\Controllers;

use App\Negocio;

use App\Propietarios;
use Illuminate\Http\Request;
use App\PropietariosLocacion;
use Illuminate\Support\Carbon;
use App\CilindrosEntradaSalida;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\PropietariosResource;

class PropietariosController extends Controller
{
  public function balance () {
    $query = DB::connection('mysql_balance_oxy');
    $a = $query->select('select*from tbl_clientes');

    $query_b = DB::connection('mysql_balance_tao');
    $b = $query_b->select('select*from tbl_clientes');
    $data['propietarios']= array_merge($a, $b);
    // dd(json_encode($data['propietarios']));
    return view('home.propietarios.balance', $data);
  }

  public function datatable_deben (Request $request) {
    $all = Propietarios::select()->addDeudaCilindro();
    // $all = Propietarios::select(
    //   '*'
    // )->join('documentos_identidad', 'entidades.tipo_doc', 'documentos_identidad.cod');

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
  public function datatable_deben_detalles (Request $request) {
    
    $make = collect();
    if ($request->has('entidad_id_val')) {
      $all = CilindrosEntradaSalida::selectRaw(
        'cilindro_id,
        cilindros_entrada_salida.ces_id as entrada_salida_id,
        cilindros.evento as cilindro_evento,
        cilindros.situacion as cilindro_situacion,
        cilindros.cargado as cilindro_cargado,
        cilindros.defectuoso as cilindro_defectuoso,
        cilindros.codigo as cilindro_codigo,
        CONCAT(comprobantes_negocio.cne_attr,\'-\',despacho.doc_serie,\'-\', despacho.doc_numero) as documento_correlativo,
        despacho.fecha_emision,
        entidades_locacion.locacion as destino_guia,
        despacho.des_id,
        ent_cil.nombre as nombre_propietario'
        )
        ->join('despacho', 'despacho.des_id', 'cilindros_entrada_salida.guia_id')
        ->join('entidades_locacion', 'entidades_locacion.elo_id', 'despacho.destino_id')
        ->join('comprobantes_negocio', 'comprobantes_negocio.cne_id', 'despacho.documento_id')
        ->join('cilindros', 'cilindros.cil_id', 'cilindros_entrada_salida.cilindro_id')
        ->join(DB::raw('entidades ent_cil'), 'ent_cil.ent_id', 'cilindros.propietario_id')
        ->where('despacho.entidad_id', $request->entidad_id_val)
        ->where('completado', '0');
    // $all = Propietarios::select(
    //   '*'
    // )->join('documentos_identidad', 'entidades.tipo_doc', 'documentos_identidad.cod');
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
    }
    $mm = $make->make(true);
    // dd($mm);
    if ($request->has('export')) {
      $casa = [];
      
      $casa = $mm->original['data'];
      // dd($casa);
      $data['rows'] = $casa;
      //considera negocio tempo como temporal
      $data['negocio'] = Negocio::find(2);
      $data['propietario'] = Propietarios::find(request('entidad_id_val'));
      $data['titulo'] = 'CILINDROS PENDIENTES';
      $pdf = PDF::loadView('home.propietarios.pdf_deben_detalles', $data);
      // $pdf = PDF::loadView('home.cilindros.pdfseguimiento', $data);
      $pdf->setPaper('A4', 'landscape');
      $pdf->setOptions(['dpi' => 250, 'fontHeightRatio' => 0.8]);

      set_time_limit(60);
      // dd($pdf);
      return $pdf->stream('DETALLES-DEUDA_'.Carbon::now().'.pdf');
      // return $pdf->download('listado.pdf');
    // dd($mm->original['data']);
    } else {
      return $mm;
    }
  }
  public function datatables (Request $request) {
    $propietario = new Propietarios();
    $all = $propietario->setTable('view_entidades_detalles')->select(
      '*'
    )->join('documentos_identidad', 'view_entidades_detalles.tipo_doc', 'documentos_identidad.cod');
    $make = DataTables::of($all)
            ->filter( function ($query) use ($request) {
                if ($request->has('buscar')) {
                    if (request('buscar') != '') {
                        $query->where( function( $query ) use($request) {
                            $query->orWhere('view_entidades_detalles.nombre', 'like', "%{$request->buscar}%");
                            $query->orWhere('view_entidades_detalles.numero', 'like', "%{$request->buscar}%");

                        });
                    }
                }
            });
    return $make->make(true);
  }

  
  /**
   * [deben_detalles description]
   * URL: home/propietarios/deben/{entidad_id}
   * @return  [type]  [return description]
   */
  public function deben_detalles (Request $request, $entidad_id) {
    $propietario = Propietarios::find($entidad_id);
    $negocios = Negocio::all();
    $negocios->makeHidden(['comprobantes']);
    $negocios->map(function ($item) {
        $item->recibos = $item->setDocumentosActivos('recibo')->comprobantes;
        $item->setDefaultFilter();
        $item->recibos->map(function ($g) {
            $g->actual = fill_zeros($g->actual);
            return $g;
        });
        return $item;
    });
    $data['negocios'] = $negocios;
    $data_vue['comprobante'] = 0;
    if ($negocios->count() > 0) {
      if ($negocios[0]->recibos->count() > 0) {
        $comprobante = $negocios[0]->recibos[0];
        $data_vue['comprobante'] = $comprobante->cne_id;
      }
    }
    $data['js'] = $data_vue;
    // dd($negocios);
    $data['propietario'] = null;


    if ($propietario) {
      $data['propietario'] = $propietario;
      $data['titulo_pagina'] = 'DEBE CILINDROS - '.$propietario->nombre;
    }

    return view('home.propietarios.debendetalles', $data);
  }
  public function deben () {
    $propietarios = Propietarios::all();
    $totales = $propietarios->map(function($item) {

      $cils = $item->cilindros_pendientes();
      $cils->map(function($b) {
        $b->cilindro = $b->cilindro->toArray();

      });
      $item->deben = $cils->toArray();
      return $item;
    });
    // dd($totales->toArray());
    $data['titulo_pagina'] = 'DEBEN CILINDROS';

    return view('home.propietarios.deben', $data);
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
          $success = $pro == null ? true : ($pro->ent_id == $propietario->ent_id);
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
