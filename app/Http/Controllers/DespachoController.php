<?php

namespace App\Http\Controllers;

use App\Cilindro;
use App\CilindroSeguimiento;
use App\CilindrosEntradaSalida;
use App\Comprobante;
use App\Despacho;
use App\DespachoCilindros;
use App\Http\Resources\ProduccionResource;
use App\Http\Resources\SistemaResource;
use App\Negocio;
use App\NegocioComprobantes;
use App\Operador;
use App\Propietarios;
use App\PropietariosLocacion;
use App\Sistema;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DespachoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['titulo_pagina'] = 'Despacho - Listar';
        return view('home.despacho.listar', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $negocios = Negocio::all();
        // dd($aa[0]);
        // dd($negocios[0]);
        // dd($negocios[0]->getDocumentoActivo('guia'));
        // return response()->json($aa);
        // exit;

        $data['edit'] = false;
        $data['no_encontrado'] = false;
        $data['negocios'] = $negocios;
        $data['operadores'] = Operador::all();
        // $sistemas = Sistema::where('attr', 's')->get();
        // $sistemas = Sistema::all();
        $negocios->makeHidden(['comprobantes']);
        $negocios->map(function ($item) {
            $item->guias = $item->setDocumentosActivos('guia')->comprobantes;
            $item->setDefaultFilter();
            $item->guias->map(function ($g) {
                $g->actual = fill_zeros($g->actual);
                return $g;
            });
            return $item;
        });
        // dd($negocios[0]->guias);
        $data['negocios'] = $negocios;


        // $data['lote'] = Lote::active()->get();
        $data['js'] = [
            'data_negocios' => $negocios,
            'negocio' => 0,
            'serie_comprobante' => '',
            'comprobante' => 0,
            'numero_comprobante' => '',
            'comprobante_success' => false,
            // 'data_lotes' => $negocios->map(function ($item) {

            //     // return $item->lote;
            // })->toArray()
        ];
        if ($negocios->count() > 0) {
            $sis = $negocios[0];
            $data['js']['negocio'] = $sis->neg_id;
            if ($sis->guias->count() > 0) {
                $comprobante = $sis->guias[0];
                // dd($comprobante);
                if ($comprobante != null) {
                    $data['js']['comprobante_success'] = true;
                    $data['js']['comprobante'] = $comprobante->cne_id;
                    $data['js']['serie_comprobante'] = $comprobante->serie;
                    // $data['js']['numero_comprobante'] = fill_zeros(8232323232329);
                    $data['js']['numero_comprobante'] = fill_zeros($comprobante->actual);
                }
            }
            // $comprobante = $sis->getDocumentoActivo('guia');
            // dd($sis);

        }
        // dd($data['js']);
        // dd($data);
        // return response()->json($data);
        $data['titulo_pagina'] = 'Despacho - Crear';
        return view('home.despacho.registro', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $valida = $request->validate([
    //         'negocio' => 'required',
    //         'comprobante' => 'required',
    //         'anular' => 'required',
    //         'serie' => 'required',
    //         'numero' => 'required',
    //         'fecha' => 'required',
    //         'motivo' => 'required',
    //         'cliente' => 'required',
    //         'destino' => 'required',
    //         'destino_nombre' => 'required',
    //         'total_cilindros' => 'required',
    //         'total_presion' => 'required',
    //         'total_cubicos' => 'required',
    //         // 'cilindros' => 'required'

    //     ]);
    //     // dd($request);
    //       // $this->validate($request, );
    //     $res = ['success' => false];
    //     // return response()->json($request);
    //     //obtener el numero de lote
    //     $negocio = Negocio::find(request('negocio'));
    //     $cliente = Propietarios::find(request('cliente'));
    //     // $guia = $negocio->getDocumentoActivo('guia');
    //     $guia = NegocioComprobantes::find(request('comprobante'));
    //     // return response()->json($request);
    //     if ($guia && $guia->negocio->neg_id == $negocio->neg_id) {
    //         DB::transaction(function () use ($guia, $negocio, $cliente) {

    //             $despacho = new Despacho();
    //             $despacho->documento_id = $guia->cne_id;
    //             $despacho->doc_nombre = $guia->nombre;
    //             $despacho->anulado = request('anular', '0');
    //             $despacho->doc_serie = $guia->serie;
    //             $despacho->doc_numero = $guia->actual;
    //             $despacho->entidad_id = request('cliente');
    //             $despacho->doc_referencia = request('referencia', '');
    //             //incrementar el correlativo
    //             $guia->actual += 1;
    //             $guia->save();
    //             //fin incremento°!
    //             $despacho->fecha_emision = request('fecha');
    //             $despacho->motivo = strtoupper(request('motivo'));
    //             $despacho->observacion = request('observacion');
    //             if (request('destino') == 0) { //agregar nueva locacion
    //                 $pre_locacion = PropietariosLocacion::existeLocacion($cliente->ent_id, request('destino_nombre'));
    //                 if ($pre_locacion == null) {
    //                     $locacion = new PropietariosLocacion();
    //                     $locacion->entidad_id = $cliente->ent_id;
    //                     $locacion->locacion = strtoupper(request('destino_nombre'));
    //                     $locacion->predeterminado = '0';
    //                     $locacion->save();

    //                     $despacho->destino_id = $locacion->elo_id;
    //                     $despacho->destino_nombre = $locacion->locacion;
    //                 } else {
    //                     $despacho->destino_id = $pre_locacion->elo_id;
    //                     $despacho->destino_nombre = $pre_locacion->locacion;
    //                 }



    //             } else {
    //                 $despacho->destino_id = request('destino');
    //                 $despacho->destino_nombre = request('destino_nombre');
    //             }

    //             $despacho->total_cilindros = request('total_cilindros');
    //             $despacho->total_presion = request('total_presion');
    //             $despacho->total_cubicos = request('total_cubicos');
    //             $despacho->doc_referencia = request('referencia');
    //             $despacho->save();



    //             //registrar cilindros y cambiar estado
    //             // $res['produccion_id']  = $produccion->pro_id;

    //             $send = [];
    //             $send_seguimiento = [];
    //             $send_entrada_salida = [];
    //             $now = Carbon::now();
    //             $cilindros_id = [];
    //             foreach (request('cilindros') as $cil) {
    //                 // $cilindro = Cilindro::find($cil['id']);

    //                 //jalar del mismo o solo
    //                 $cilindros_id[] = $cil['id'];
    //                 $send[] = [
    //                     'despacho_id' => $despacho->des_id,
    //                     'cilindro_id' => $cil['id'],
    //                     'des_capacidad' => $cil['capacidad'],
    //                     'des_presion' => $cil['cantidad'],
    //                     'des_cubico' => $cil['capacidad'],
    //                     'propietario_nombre' => $cil['propietario'],
    //                     'cilindro_serie' => $cil['serie'],
    //                     'cilindro_codigo' => $cil['codigo'],
    //                     'observacion' => $cil['observacion'],
    //                     'cilindro_tapa' => ''.$cil['tapa'].'',
    //                     'created_at' => $now,
    //                     'updated_at' => $now
    //                 ];

    //                 $send_seguimiento[] = [
    //                     'cilindro_id' => $cil['id'],
    //                     'created_at' => $now,
    //                     'updated_at' => $now,
    //                     'evento' => 'despacho',
    //                     'descripcion' => 'Cilindro registrado en despacho, listo para salir',
    //                     'referencia_id' => $despacho->des_id,
    //                     'origen' => 'app',
    //                     'fecha' => request('fecha')
    //                 ];

    //                 $send_entrada_salida[] = [
    //                     'cilindro_id' => $cil['id'],
    //                     'salida' => request('fecha'),
    //                     'guia_id' => $despacho->des_id,
    //                     'observacion_salida' => $cil['observacion'],
    //                     'created_at' => $now,
    //                     'updated_at' => $now,
    //                 ];

    //                 //agregar seguimiento de salida llega y confirmación



    //                 //FINagregar seguimiento de salida llega y confirmación

    //                 // $send_seguimiento[] = [
    //                 //     'cilindro_id' => $cil['id'],
    //                 //     'created_at' => $now,
    //                 //     'updated_at' => $now,
    //                 //     'evento' => 'despacho',
    //                 //     'descripcion' => 'Cilindro registrado en despacho, listo para salir',
    //                 //     'referencia_id' => $despacho->des_id,
    //                 //     'origen' => 'app',
    //                 //     'fecha' => $now
    //                 // ];

    //                 // $cilindro->cargado = 2;
    //                 // $cilindro
    //                 // $cilindro->situación = 2;
    //             }
    //             if (request('anular') != '1') {
    //                 //CAMBIAR SITUACION DE CILINDRO A -> TRANSPORTE
    //                 // $estado = Cilindro::getSituacion('transporte');

    //                 // Cilindro::whereIn('cil_id', $send->map(function ($item) {
    //                 //         return $item['cilindro_id'];
    //                 //     }))->update(['situacion' => $estado]);

    //                 Cilindro::whereIn('cil_id', $cilindros_id)->update(['evento' => 'despacho']);
    //                 CilindroSeguimiento::insert($send_seguimiento);
    //                 CilindrosEntradaSalida::insert($send_entrada_salida);

    //                 //seguimiento ara salida y llegada

    //             }
    //             if (count($send) > 0)
    //                 DespachoCilindros::insert($send);
    //         });

    //         // $res['detalles'] = $produccion->detalles;
    //         $res['success'] = true;
    //     }


    //     return response()->json($res);
    // }
    public function store(Request $request)
    {
        // dd($request);
        $valida = $request->validate([
            'negocio' => 'required',
            'comprobante' => 'required',
            'anular' => 'required',
            'serie' => 'required',
            'numero' => 'required',
            'fecha' => 'required',
            'motivo' => 'required',
            'cliente' => 'required',
            'destino' => 'required',
            'destino_nombre' => 'required',
            'total_cilindros' => 'required',
            'total_presion' => 'required',
            'total_cubicos' => 'required',
            // 'cilindros' => 'required'

        ]);
        // dd(+$request->numero);
          // $this->validate($request, );
        $res = ['success' => false, 'show_message' => false, 'msg' => ''];
        // return response()->json($request);
        //obtener el numero de lote
        $negocio = Negocio::find(request('negocio'));
        $cliente = Propietarios::find(request('cliente'));
        // $guia = $negocio->getDocumentoActivo('guia');
        $guia = NegocioComprobantes::find(request('comprobante'));
        // return response()->json($request);
        $procesa = true;
        if (Despacho::existe_numero(request('comprobante'), +request('numero'))) {
            $procesa = false;
            $res['show_message'] = true;
            $res['msg'] = 'El número de guía se encuentra registrado';
        }
        if ($procesa && $guia && $guia->negocio->neg_id == $negocio->neg_id) {
            DB::transaction(function () use ($guia, $negocio, $cliente) {

                $despacho = new Despacho();
                $despacho->documento_id = $guia->cne_id;
                $despacho->doc_nombre = $guia->nombre;
                $despacho->anulado = request('anular', '0');
                $despacho->doc_serie = $guia->serie;

                $despacho->entidad_id = request('cliente');

                $despacho->salida = '1';
                $despacho->fecha_salida = request('fecha');

                $despacho->llegada = '1';
                $despacho->fecha_llegada = request('fecha');

                $despacho->confirmada = '1';
                $despacho->fecha_confirmada = request('fecha');

                $despacho->doc_referencia = request('referencia', '');
                //incrementar el correlativo
                $numero_doc = +request('numero');
                if ($numero_doc >= $guia->actual){

                    if ($numero_doc > $guia->actual){
                        $despacho->doc_numero = $numero_doc;
                        $guia->actual = $numero_doc + 1;
                    } else {
                        $despacho->doc_numero = $guia->actual;
                        $guia->actual += 1;
                    }
                } else {
                    $despacho->doc_numero = $numero_doc;
                    // if ($guia->actual < +$numero_doc)
                    // $next_numero = $numero_doc + 1;
                    // if (Despacho::existe_numero(+request('comprobante'), $next_numero))
                    // $guia->actual = +$numero_doc + 1;
                }

                // if (+request('numero') == $guia->actual){
                //     $despacho->doc_numero = $guia->actual;
                //     $guia->actual += 1;
                // } else {
                //     $despacho->doc_numero = +request('numero');
                //     if ($guia->actual < +request('numero'))
                //         $guia->actual = +request('numero') + 1;
                // }


                $guia->save();
                //fin incremento°!
                $despacho->fecha_emision = request('fecha');
                $despacho->motivo = 'venta';
                // $despacho->motivo = strtoupper(request('motivo'));
                $despacho->observacion = request('observacion');
                if (request('destino') == 0) { //agregar nueva locacion
                    $pre_locacion = PropietariosLocacion::existeLocacion($cliente->ent_id, request('destino_nombre'));
                    if ($pre_locacion == null) {
                        $locacion = new PropietariosLocacion();
                        $locacion->entidad_id = $cliente->ent_id;
                        $locacion->locacion = strtoupper(request('destino_nombre'));
                        $locacion->predeterminado = '0';
                        $locacion->save();

                        $despacho->destino_id = $locacion->elo_id;
                        $despacho->destino_nombre = $locacion->locacion;
                    } else {
                        $despacho->destino_id = $pre_locacion->elo_id;
                        $despacho->destino_nombre = $pre_locacion->locacion;
                    }



                } else {
                    $despacho->destino_id = request('destino');
                    $despacho->destino_nombre = request('destino_nombre');
                }

                $despacho->total_cilindros = request('total_cilindros');
                $despacho->total_presion = request('total_presion');
                $despacho->total_cubicos = request('total_cubicos');
                $despacho->doc_referencia = request('referencia');
                $despacho->save();



                //registrar cilindros y cambiar estado
                // $res['produccion_id']  = $produccion->pro_id;

                $send = [];
                $send_seguimiento = [];
                $send_entrada_salida = [];
                $now = Carbon::now();
                $cilindros_id = [];
                foreach (request('cilindros') as $cil) {
                    // $cilindro = Cilindro::find($cil['id']);

                    //jalar del mismo o solo
                    $cilindros_id[] = $cil['id'];
                    $send[] = [
                        'despacho_id' => $despacho->des_id,
                        'cilindro_id' => $cil['id'],
                        'des_capacidad' => $cil['capacidad'],
                        'des_presion' => $cil['cantidad'],
                        'propietario_id' => $cil['propietario_id'],
                        'des_cubico' => $cil['capacidad'],
                        'propietario_nombre' => $cil['propietario'],
                        'cilindro_serie' => $cil['serie'],
                        'cilindro_codigo' => $cil['codigo'],
                        'observacion' => $cil['observacion'],
                        'cilindro_tapa' => ''.$cil['tapa'].'',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                    $orden_seg = 1;
                    if (CilindroSeguimiento::existe_en_fecha($cil['id'], request('fecha'))) {
                        $orden_seg = CilindroSeguimiento::extraer_nuevo_orden($cil['id'], request('fecha'));
                    }
                    $send_seguimiento[] = [
                        'cilindro_id' => $cil['id'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'evento' => 'despacho',
                        'orden_seg' => $orden_seg,
                        'descripcion' => 'Cilindro registrado en despacho, listo para salir',
                        'referencia_id' => $despacho->des_id,
                        'origen' => 'app',
                        'fecha' => request('fecha'),
                        'fecha_detalle' => request('fecha')
                    ];

                    $send_seguimiento_salida[] = [
                        'cilindro_id' => $cil['id'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'evento' => 'transporte',
                        'orden_seg' => $orden_seg,
                        'descripcion' => 'Cilindro en transporte con destino al cliente',
                        'referencia_id' => $despacho->des_id,
                        'origen' => 'app',
                        'fecha_detalle' => request('fecha'),
                        'fecha' => request('fecha')
                    ];
                    $send_seguimiento_llegada[] = [
                        'cilindro_id' => $cil['id'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'evento' => 'cliente',
                        'orden_seg' => $orden_seg,
                        'descripcion' => 'Cilindro en cliente',
                        'referencia_id' => $despacho->des_id,
                        'origen' => 'app',
                        'fecha_detalle' => request('fecha'),
                        'fecha' => request('fecha')
                    ];

                    $send_entrada_salida[] = [
                        'cilindro_id' => $cil['id'],
                        'salida' => request('fecha'),
                        'guia_id' => $despacho->des_id,
                        'observacion_salida' => $cil['observacion'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];

                    //agregar seguimiento de salida llega y confirmación



                    //FINagregar seguimiento de salida llega y confirmación

                    // $send_seguimiento[] = [
                    //     'cilindro_id' => $cil['id'],
                    //     'created_at' => $now,
                    //     'updated_at' => $now,
                    //     'evento' => 'despacho',
                    //     'descripcion' => 'Cilindro registrado en despacho, listo para salir',
                    //     'referencia_id' => $despacho->des_id,
                    //     'origen' => 'app',
                    //     'fecha' => $now
                    // ];

                    // $cilindro->cargado = 2;
                    // $cilindro
                    // $cilindro->situación = 2;
                }
                if (request('anular') != '1') {
                    //CAMBIAR SITUACION DE CILINDRO A -> TRANSPORTE
                    // $estado = Cilindro::getSituacion('transporte');

                    // Cilindro::whereIn('cil_id', $send->map(function ($item) {
                    //         return $item['cilindro_id'];
                    //     }))->update(['situacion' => $estado]);

                    Cilindro::whereIn('cil_id', $cilindros_id)->update([
                        'despacho_id_salida' => $despacho->des_id,
                        'evento' => 'despacho'
                    ]);
                    CilindroSeguimiento::insert($send_seguimiento);
                    CilindrosEntradaSalida::insert($send_entrada_salida);

                    //salida
                    Cilindro::whereIn('cil_id', $cilindros_id)->update(['situacion' => Cilindro::getSituacion('transporte'), 'evento' => 'transporte']);
                    CilindroSeguimiento::insert($send_seguimiento_salida);
                    //llegada
                    Cilindro::whereIn('cil_id', $cilindros_id)->update(['situacion' => Cilindro::getSituacion('cliente'), 'evento' => 'cliente']);
                    CilindroSeguimiento::insert($send_seguimiento_llegada);


                    //seguimiento ara salida y llegada

                }
                if (count($send) > 0)
                    DespachoCilindros::insert($send);
            });

            // $res['detalles'] = $produccion->detalles;
            $res['success'] = true;
        }


        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Despacho  $despacho
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        if ($id == 'datatable') {
            $all = collect();
            // DB::enableQueryLog();
            $name_code = '';
            if ($request->filled('m')) {
                switch (request('m')) {
                    case 'despacho':
                        $name_code = 'guia';
                        break;
                    case 'recibo':
                        $name_code = 'recibo';
                        break;
                }
            }


            if (($code = Comprobante::getCode($name_code)) != 'undefined') {
                // $all = Despacho::getAllByProceso($code)->get()->map(function ($item) {
                //     $item->destino->entidad;
                //     $item->guia->negocio;
                //     $item->doc_numero = fill_zeros($item->doc_numero);
                //     return $item;
                // });

                $all = Despacho::with(['destino.entidad', 'guia.negocio'])
                        ->join('entidades', 'entidades.ent_id', '=', 'despacho.entidad_id')
                        ->leftJoin('despacho_cilindros', 'despacho_cilindros.despacho_id', '=', 'despacho.des_id')
                        ->getAllByProceso($code)->selectRaw('distinct despacho.*, entidades.nombre');

                $make = DataTables::of($all)
                        ->filter( function ($query) use ($request) {
                            if ($request->has('buscar')) {
                                if (request('buscar') != '') {
                                    $query->where( function( $query ) use($request) {
                                        $query->where('doc_numero', 'like', "%{$request->buscar}%");
                                        $query->orWhere('despacho_cilindros.cilindro_serie', 'like', "%{$request->buscar}%");
                                        $query->orWhere('despacho_cilindros.cilindro_codigo', 'like', "%{$request->buscar}%");
                                        $query->orWhere('entidades.nombre', 'like', "%{$request->buscar}%");
                                        // $query->orWhere('apellidos', 'like', "%{$request->buscar}%");
                                    });
                                    // $query->operador()->where
                                }


                                // $query->orWhere('numero_lote', 'like', "%{$custom['query']}%");
                                // $query->orWhere('cilindro', 'like', "%{$custom['query']}%");
                            }

                            if ($request->has('filtro_date') && $request->has('desde') && $request->has('hasta')) {
                                if ($request->filtro_date == 'interval') {
                                    $query->where('fecha_emision', '>=', $request->desde);
                                    $query->where('fecha_emision', '<=', $request->hasta);
                                }
                                if ($request->filtro_date == 'same') {
                                    $query->where('fecha_emision', '=', $request->desde);
                                }
                            }
                        })
                        ->editColumn('doc_numero', '{{ fill_zeros($doc_numero) }}');
                return $make->make(true);
            } else {
                // $all = Despacho::all()->map(function ($item) {
                //     $item->destino->entidad;
                //     $item->guia->negocio;
                //     $item->doc_numero = fill_zeros($item->doc_numero);
                //     return $item;
                // });
            }

            // $all[0]->documento;
            // $all = Despacho::Test()->get();
            // $all = Despacho::getAllByProceso('despacho');
            // $all = Despacho::hola();

            // $all = Despacho::all()->map(function ($item) {
            //     $item->destino->entidad;
            //     $item->guia->negocio;
            //     $item->doc_numero = fill_zeros($item->doc_numero);
            //     return $item;
            // });
            // $query = DB::getQueryLog();
            // dd(['query' => $query, 'data' => $all]);
            // return response()->json(['query' => $query, 'data' => $all]);
            // return response()->json(ProduccionResource::collection($all));
        } else {
            $despacho = Despacho::find($id);

            // $despacho->fecha = Carbon::createFromFormat('Y-m-d', $despacho->fecha)->format('d/m/y');

            // $dd = new ProduccionResource($despacho);
            // return response()->json($dd);
            $data['despacho'] = $despacho;
            $data['destino'] = $despacho->destino;
            $data['documento'] = $despacho->documento;
            $data['cilindros'] = $despacho->detalles;
            $data['entidad'] = $despacho->destino->entidad;
            // dd($despacho);
            $data['titulo_pagina'] = $data['documento']->nombre.', '.$despacho->doc_serie.'-'.fill_zeros($despacho->doc_numero);
            // $data['despacho'] = $despacho;
            return view('home.despacho.detalles', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Despacho  $despacho
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $negocios = Negocio::all();
        // dd($negocios[0]);
        // dd($negocios[0]->getDocumentoActivo('guia'));
        // return response()->json($aa);
        // exit;
        $despacho = Despacho::find($id);
        $data['no_encontrado'] = $despacho == null;
        $data['edit'] = true;
        $data['negocios'] = $negocios;

        $data['despacho'] = $despacho;
        $data['operadores'] = Operador::all();
        // $sistemas = Sistema::where('attr', 's')->get();
        // $sistemas = Sistema::all();
        if (!$data['no_encontrado']) {
            $despacho->detalles->map(function($item) {
                $item->propietario;
                return $item;
            });
            $despacho->destino->entidad->documento;
            $despacho->destino->entidad->locaciones;
            $negocios->makeHidden(['comprobantes']);
            $negocios->map(function ($item) {
                $item->guias = $item->setDocumentosActivos('guia')->comprobantes;
                $item->setDefaultFilter();
                $item->guias->map(function ($g) {
                    $g->actual = fill_zeros($g->actual);
                    return $g;
                });
                return $item;
            });
            // dd($negocios[0]->guias);
            $data['negocios'] = $negocios;


            // $data['lote'] = Lote::active()->get();
            $data['js'] = [
                'is_edit' => true,
                'data_despacho' => $despacho,
                'data_negocios' => $negocios,
                'negocio' => 0,
                'serie_comprobante' => '',
                'comprobante' => 0,
                'numero_comprobante' => '',
                'comprobante_success' => false,
                // 'data_lotes' => $negocios->map(function ($item) {

                //     // return $item->lote;
                // })->toArray()
            ];
            if ($negocios->count() > 0) {
                $sis = $negocios[0];
                $data['js']['negocio'] = $sis->neg_id;
                if ($sis->guias->count() > 0) {
                    $comprobante = $sis->guias[0];
                    // dd($comprobante);
                    if ($comprobante != null) {
                        $data['js']['comprobante_success'] = true;
                        $data['js']['comprobante'] = $comprobante->cne_id;
                        $data['js']['serie_comprobante'] = $comprobante->serie;
                        // $data['js']['numero_comprobante'] = fill_zeros(8232323232329);
                        $data['js']['numero_comprobante'] = fill_zeros($comprobante->actual);
                    }
                }
                // $comprobante = $sis->getDocumentoActivo('guia');
                // dd($sis);

            }
        }
        // dd($data['js']);
        // dd($data);
        // return response()->json($data);
        $data['titulo_pagina'] = 'Despacho - Editar';
        return view('home.despacho.registro', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Despacho  $despacho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $res = ['success' => false, 'show_message' => false, 'msg' => ''];
        if ($request->filled('metodo')) {
            $despacho = Despacho::find($id);
            if ($despacho) {
                DB::transaction(function () use ($despacho, $request, &$res) {
                    $now = Carbon::now();
                    $metodo = request('metodo');
                    switch ($metodo) {
                        //utiliado al editar despacho
                        case 'modificar_despacho':
                            // dd($request);
                            $valida = $request->validate([
                                'negocio' => 'required',
                                'comprobante' => 'required',
                                'anular' => 'required',
                                'serie' => 'required',
                                'numero' => 'required',
                                'fecha' => 'required',
                                // 'motivo' => 'required',
                                'cliente' => 'required',
                                'destino' => 'required',
                                'destino_nombre' => 'required',
                                'total_cilindros' => 'required',
                                'total_presion' => 'required',
                                'total_cubicos' => 'required',
                                // 'cilindros' => 'required'
                            ]);

                            $negocio = Negocio::find($request->negocio);
                            $cliente = Propietarios::find($request->cliente);
                            $guia = NegocioComprobantes::find($request->comprobante);
                            $procesa = true;

                            if (!($despacho->documento_id == $request->comprobante && +$despacho->doc_numero == +$request->numero)) {
                                if (Despacho::existe_numero($request->comprobante, +$request->numero)) {
                                    $procesa = false;
                                    $res['show_message'] = true;
                                    $res['msg'] = 'El número de guía se encuentra registrado';
                                }
                            }


                            if ($procesa && $guia && $guia->negocio->neg_id == $negocio->neg_id) {

                                    // $despacho = new Despacho();
                                    $despacho->documento_id = $guia->cne_id;
                                    $despacho->doc_nombre = $guia->nombre;
                                    $despacho->anulado = request('anular', '0');
                                    $despacho->doc_serie = $guia->serie;

                                    $despacho->entidad_id = request('cliente');

                                    $despacho->salida = '1';
                                    $despacho->fecha_salida = request('fecha');

                                    $despacho->llegada = '1';
                                    $despacho->fecha_llegada = request('fecha');

                                    $despacho->confirmada = '1';
                                    $despacho->fecha_confirmada = request('fecha');

                                    $despacho->doc_referencia = request('referencia', '');
                                    //incrementar el correlativo

                                    $despacho->doc_numero = +request('numero');
                                    // $guia->actual = +request('numero') + 1;



                                    // $guia->save();
                                    //fin incremento°!
                                    $despacho->fecha_emision = request('fecha');
                                    $despacho->motivo = 'venta';
                                    // $despacho->motivo = strtoupper(request('motivo'));
                                    $despacho->observacion = request('observacion');
                                    if (request('destino') == 0) { //agregar nueva locacion
                                        $pre_locacion = PropietariosLocacion::existeLocacion($cliente->ent_id, request('destino_nombre'), true);
                                        // if ($pre_locacion == null) {
                                        //     $locacion = new PropietariosLocacion();
                                        //     $locacion->entidad_id = $cliente->ent_id;
                                        //     $locacion->locacion = strtoupper(request('destino_nombre'));
                                        //     $locacion->predeterminado = '0';
                                        //     $locacion->save();

                                        //     $despacho->destino_id = $locacion->elo_id;
                                        //     $despacho->destino_nombre = $locacion->locacion;
                                        // } else {
                                        $despacho->destino_id = $pre_locacion->elo_id;
                                        $despacho->destino_nombre = $pre_locacion->locacion;
                                        // }



                                    } else {
                                        $despacho->destino_id = request('destino');
                                        $despacho->destino_nombre = request('destino_nombre');
                                    }

                                    $despacho->total_cilindros = request('total_cilindros');
                                    $despacho->total_presion = request('total_presion');
                                    $despacho->total_cubicos = request('total_cubicos');
                                    $despacho->doc_referencia = request('referencia');
                                    $despacho->save();



                                    //registrar cilindros y cambiar estado
                                    // $res['produccion_id']  = $produccion->pro_id;

                                    $send = [];
                                    $send_seguimiento = [];
                                    $send_entrada_salida = [];
                                    $send_seguimiento_salida = [];
                                    $send_seguimiento_llegada = [];
                                    $now = Carbon::now();
                                    $cilindros_id = [];
                                    $cilindros_actuales = $despacho->detalles;
                                    //recolectar solo el id de los cilindros actualmente registrados
                                    $cilindros_id_actuales = $despacho->detalles->map(function($item) {
                                        return $item->cilindro_id;
                                    });
                                    $eliminar_id = [];
                                    $actualizar_id = [];
                                    //temporal, id de cilindros que serán registrados y/o actualizados
                                    foreach (request('cilindros') as $cil) {
                                        $cilindros_id[] = $cil['id'];
                                    }
                                    //determinar que cilindros serán eliminado
                                    foreach ($cilindros_id_actuales as $key => $value) {
                                        if (in_array($value, $cilindros_id)) {
                                            $actualizar_id[] = $value;
                                        } else {
                                            $eliminar_id[] = $value;
                                        }
                                    }
                                    //eliminar
                                    //el seguimiento del cilindro
                                    //la salida
                                    //
                                    foreach ($eliminar_id as $key => $value) {
                                        $despacho->detalles->where('cilindro_id', $value)->where('despacho_id', $despacho->des_id)->first()->delete();

                                        CilindroSeguimiento::eliminar($value, 'despacho', $despacho->des_id, 'app');
                                        CilindroSeguimiento::eliminar($value, 'transporte', $despacho->des_id, 'app');
                                        CilindroSeguimiento::eliminar($value, 'cliente', $despacho->des_id, 'app');


                                        CilindrosEntradaSalida::where('cilindro_id', $value)->where('guia_id', $despacho->des_id)->first()->delete();

                                        //no se regresa a un estado previo en editar?


                                        $eventos = CilindroSeguimiento::where('cilindro_id', $value)
                                            ->whereIn('evento', ['vacio', 'cargando', 'cargado', 'despacho', 'transporte', 'cliente'])
                                            ->where('fecha', '>=', $despacho->fecha_emision)
                                            ->get();
                                        if ($eventos->count() == 0) {
                                            //modificar el estado del cilindro
                                            $cilindro = Cilindro::find($value);
                                            $cilindro->situacion = Cilindro::getSituacion('fabrica');
                                            $cilindro->cargado = Cilindro::getEstado('cargado');
                                            $cilindro->evento = 'cargado';
                                            $cilindro->despacho_id_salida = 0;
                                            $cilindro->save();
                                        }

                                    }
                                    foreach (request('cilindros') as $cil) {
                                        // $cilindro = Cilindro::find($cil['id']);

                                        //jalar del mismo o solo
                                        $registra = true;
                                        // foreach ($actualizar_id as $key => $value) {
                                            // if ($value == $cil['id']) {
                                            if ($cil['registrado'] == 1 && in_array($cil['id'], $actualizar_id)) {
                                                //actualizar los seguimeintos y la entrada y salida
                                                $detalle_temp = $cilindros_actuales->where('cilindro_id', $cil['id'])->first();
                                                if ($detalle_temp) {
                                                    $detalle_temp->des_capacidad = $cil['capacidad'];
                                                    $detalle_temp->des_presion = $cil['cantidad'];
                                                    $detalle_temp->des_cubico = $cil['capacidad'];
                                                    $detalle_temp->propietario_id = $cil['propietario_id'];
                                                    $detalle_temp->propietario_nombre = $cil['propietario'];
                                                    $detalle_temp->cilindro_serie = $cil['serie'];
                                                    $detalle_temp->cilindro_codigo = $cil['codigo'];
                                                    $detalle_temp->observacion = $cil['observacion'];
                                                    $detalle_temp->cilindro_tapa = ''.$cil['tapa'];
                                                    $detalle_temp->save();

                                                    CilindroSeguimiento::where('cilindro_id', $cil['id'])
                                                        ->where('referencia_id', $despacho->des_id)
                                                        ->whereIn('evento', ['despacho', 'transporte', 'cliente'])
                                                        ->update([
                                                        'fecha' => request('fecha'),
                                                        'fecha_detalle' => request('fecha')
                                                    ]);

                                                    CilindrosEntradaSalida::where('cilindro_id', $cil['id'])
                                                        ->where('guia_id', $despacho->des_id)
                                                        ->update([
                                                        'salida' => request('fecha'),
                                                        'observacion_salida' => $cil['observacion']
                                                    ]);
                                                    $registra = false;
                                                }
                                                break;
                                            }
                                        // }
                                        // $cilindros_id[] = $cil['id'];
                                        // if ($registra) {
                                        if ($cil['registrado'] == 0) {
                                            $send[] = [
                                                'despacho_id' => $despacho->des_id,
                                                'cilindro_id' => $cil['id'],
                                                'des_capacidad' => $cil['capacidad'],
                                                'des_presion' => $cil['cantidad'],
                                                'propietario_id' => $cil['propietario_id'],
                                                'des_cubico' => $cil['capacidad'],
                                                'propietario_nombre' => $cil['propietario'],
                                                'cilindro_serie' => $cil['serie'],
                                                'cilindro_codigo' => $cil['codigo'],
                                                'observacion' => $cil['observacion'],
                                                'cilindro_tapa' => ''.$cil['tapa'].'',
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now()
                                            ];

                                            $send_seguimiento[] = [
                                                'cilindro_id' => $cil['id'],
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                                'evento' => 'despacho',
                                                'descripcion' => 'Cilindro registrado en despacho, listo para salir',
                                                'referencia_id' => $despacho->des_id,
                                                'origen' => 'app',
                                                'fecha' => request('fecha'),
                                                'fecha_detalle' => request('fecha')
                                            ];
                                            $send_seguimiento_salida[] = [
                                                'cilindro_id' => $cil['id'],
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                                'evento' => 'transporte',
                                                'descripcion' => 'Cilindro en transporte con destino al cliente',
                                                'referencia_id' => $despacho->des_id,
                                                'origen' => 'app',
                                                'fecha' => request('fecha'),
                                                'fecha_detalle' => request('fecha')
                                            ];
                                            $send_seguimiento_llegada[] = [
                                                'cilindro_id' => $cil['id'],
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                                'evento' => 'cliente',
                                                'descripcion' => 'Cilindro en cliente',
                                                'referencia_id' => $despacho->des_id,
                                                'origen' => 'app',
                                                'fecha' => request('fecha'),
                                                'fecha_detalle' => request('fecha')
                                            ];

                                            $send_entrada_salida[] = [
                                                'cilindro_id' => $cil['id'],
                                                'salida' => request('fecha'),
                                                'guia_id' => $despacho->des_id,
                                                'observacion_salida' => $cil['observacion'],
                                                'created_at' => Carbon::now(),
                                                'updated_at' => Carbon::now(),
                                            ];
                                        }
                                    }

                                    if (request('anular') != '1') {
                                        //CAMBIAR SITUACION DE CILINDRO A -> TRANSPORTE
                                        // $estado = Cilindro::getSituacion('transporte');

                                        // Cilindro::whereIn('cil_id', $send->map(function ($item) {
                                        //         return $item['cilindro_id'];
                                        //     }))->update(['situacion' => $estado]);

                                        Cilindro::whereIn('cil_id', $cilindros_id)->update([
                                            'despacho_id_salida' => $despacho->des_id,
                                            'evento' => 'despacho'
                                        ]);
                                        CilindroSeguimiento::insert($send_seguimiento);
                                        CilindrosEntradaSalida::insert($send_entrada_salida);

                                        //salida
                                        Cilindro::whereIn('cil_id', $cilindros_id)->update(['situacion' => Cilindro::getSituacion('transporte'), 'evento' => 'transporte']);
                                        CilindroSeguimiento::insert($send_seguimiento_salida);
                                        //llegada
                                        Cilindro::whereIn('cil_id', $cilindros_id)->update(['situacion' => Cilindro::getSituacion('cliente'), 'evento' => 'cliente']);
                                        CilindroSeguimiento::insert($send_seguimiento_llegada);


                                        //seguimiento ara salida y llegada

                                    }
                                    if (count($send) > 0)
                                        DespachoCilindros::insert($send);




                                // $res['detalles'] = $produccion->detalles;
                                $res['success'] = true;
                            }



                            break;
                        case 'confirmar_llegada':
                            $despacho->confirmada = '1';
                            // $despacho->fecha_confirmada = $now;//en modo normal usando estados
                            $despacho->fecha_confirmada = $despacho->fecha_llegada;
                            $despacho->save();
                            $res['success'] = true;

                            break;
                        case 'registrar_hora_salida':
                        case 'registrar_hora_llegada':
                            $valida = $request->validate([
                                'hora' => 'required'
                            ]);
                            $estado = '';
                            $evento = '';
                            if ($metodo == 'registrar_hora_salida') {
                                $despacho->salida = '1';
                                $despacho->fecha_salida = request('hora');//es un datetime
                                $estado = Cilindro::getSituacion('transporte');
                                $evento = 'transporte';
                            }

                            if ($metodo == 'registrar_hora_llegada') {
                                $despacho->llegada = '1';
                                $despacho->fecha_llegada = request('hora');//es un datetime
                                $estado = Cilindro::getSituacion('cliente');
                                $evento = 'cliente';

                                $despacho->confirmada = '1';
                                // $despacho->fecha_confirmada = $now;//en modo normal usando estados
                                $despacho->fecha_confirmada = request('hora');
                                // $despacho->save();
                                // $res['success'] = true;
                            }

                            $despacho->save();
                            //cambiar estado de los cilindros
                            $cilindros = $despacho->detalles->toArray();
                            $cilindros_id = [];
                            $send_seguimiento = [];


                            foreach ($cilindros as $cil) {
                                $cilindros_id[] = $cil['cilindro_id'];
                                $temp_value = [
                                    'cilindro_id' => $cil['cilindro_id'],
                                    'created_at' => $now,
                                    'evento' => '',
                                    'descripcion' => '',
                                    'updated_at' => $now,
                                    'referencia_id' => $despacho->des_id,
                                    'origen' => 'app',
                                    'fecha' => request('hora')
                                ];

                                if ($metodo == 'registrar_hora_salida') {
                                    $temp_value['evento'] = 'transporte';
                                    $temp_value['descripcion'] = 'Cilindro en transporte con destino al cliente';
                                }

                                if ($metodo == 'registrar_hora_llegada') {

                                    $temp_value['evento'] = 'cliente';
                                    $temp_value['descripcion'] = 'Cilindro en cliente';
                                }

                                $send_seguimiento[] = $temp_value;




                            }

                            // $cilindros->map(function ($cil) use ($despacho, $now, &$cilindros_id, &$send_seguimiento) {
                            //     $cilindros_id[] = $cil->cilindro_id;
                            //     $send_seguimiento[] = [
                            //         'cilindro_id' => $cil->cilindro_id,
                            //         'created_at' => $now,
                            //         'updated_at' => $now,
                            //         'evento' => 'cliente',
                            //         'descripcion' => 'Cilindro en cliente',
                            //         'referencia_id' => $despacho->des_id,
                            //         'origen' => 'app',
                            //         'fecha' => request('hora')
                            //     ];
                            //     // $cil->cilindro->situacion = Cilindro::getSituacion('cliente');
                            //     // $cil->cilindro->save();
                            // });

                            Cilindro::whereIn('cil_id', $cilindros_id)->update(['situacion' => $estado, 'evento' => $evento]);

                            CilindroSeguimiento::insert($send_seguimiento);
                            $res['success'] = true;
                            break;
                    }
                });

                $res['data'] = $despacho;
            }
        }
        return response()->json($res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Despacho  $despacho
     * @return \Illuminate\Http\Response
     */
    public function destroy(Despacho $despacho)
    {
        //
    }
}
