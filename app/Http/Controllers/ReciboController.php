<?php

namespace App\Http\Controllers;

use App\Cilindro;
use App\CilindroSeguimiento;
use App\CilindrosEntradaSalida;
use App\Despacho;
use App\DespachoCilindros;
use App\Negocio;
use App\NegocioComprobantes;
use App\Propietarios;
use App\PropietariosLocacion;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReciboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['titulo_pagina'] = 'RECIBO LISTAR';
        return view('home.recibo.listar', $data);
    }

    public function registrar_cilindro (Request $request) {
      // dd($request);
      $res = ['success' => false];
      $validate = $request->validate([
        'cilindro_id' => 'required',
        'numero_doc' => 'required',
        'entrada_salida_id' => 'required',
        'recibo_id' => 'required'
      ]);
      $ces = CilindrosEntradaSalida::find(request('entrada_salida_id'));
      
      $recibo = Despacho::find(request('recibo_id'));
      if ($ces && $recibo) {
        $ces->entrada = $recibo->fecha_emision;
        $ces->recibo_id = $recibo->des_id;
        $ces->observacion_entrada = 'AGREGADO DESDE DEUDA';
        $ces->completado = '1';
        $res['success'] = $ces->save();
      }
      return response()->json($res);
    }
    /**
     * [verificar_cilindro Existencia de cilindro en un recibo]
     *
     * @return  [type]  [return description]
     */
    public function verificar_cilindro (Request $request) {
      // dd($request);
      $res = ['success' => false, 'recibo_id' => null];
      $validate = $request->validate([
        'cilindro_id' => 'required',
        'numero_doc' => 'required',
        'comprobante_id' => 'required'
      ]);
      if ($validate) {
        $doc = Despacho::getByNumeroAndDoc(request('comprobante_id'), request('numero_doc'));
        if ($doc && $doc->eliminado == 0) {
          $cilindro = $doc->detalles()->where('cilindro_id', request('cilindro_id'))->count() > 0 ? true : false;
          if ($cilindro) {
            $res['success'] = true;
            $res['recibo_id'] = $doc->des_id;

          }
        }
      }
      return response()->json($res);
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
        $data['negocios'] = $negocios;
        $data['no_encontrado'] = false;

        // $sistemas = Sistema::where('attr', 's')->get();
        // $sistemas = Sistema::all();
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
            if ($sis->recibos->count() > 0) {
                $comprobante = $sis->recibos[0];
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
        $data['titulo_pagina'] = 'RECIBO REGISTRAR';
        return view('home.recibo.registro', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $valida = $request->validate([
            'negocio' => 'required',
            'comprobante' => 'required',
            'anular' => 'required',
            'serie' => 'required',
            'numero' => 'required',
            'fecha' => 'required',
            'fecha_detalle' => 'required',
            // 'motivo' => 'required',
            'cliente' => 'required',
            'destino' => 'required',
            'destino_nombre' => 'required',
            'total_cilindros' => 'required',
            'total_presion' => 'required',
            'total_cubicos' => 'required',
            // 'cilindros' => 'required'

        ]);
          // $this->validate($request, );
        $res = ['success' => false];
        // return response()->json($request);
        //obtener el numero de lote
        $negocio = Negocio::find(request('negocio'));
        $cliente = Propietarios::find(request('cliente'));
        $recibo = NegocioComprobantes::find(request('comprobante'));
        // dd($request);
        // $guia = $negocio->getDocumentoActivo('guia');
        // return response()->json($recibo);
        if ($recibo && $recibo->negocio->neg_id == $negocio->neg_id) {
        // if ($guia && $guia->cne_id == request('comprobante')) {
            DB::transaction(function () use ($recibo, $negocio, $cliente) {
                $now = Carbon::now();
                $proceso = new Despacho();
                $proceso->documento_id = $recibo->cne_id;
                $proceso->anulado = request('anular', '0');
                $proceso->doc_serie = $recibo->serie;
                $proceso->doc_numero = $recibo->actual;
                $proceso->doc_nombre = $recibo->nombre;
                // $recibo->doc_referencia = request('referencia', '');
                //incrementar el correlativo

                // if (+request('numero') == $recibo->actual){
                //     $proceso->doc_numero = $recibo->actual;
                //     $recibo->actual += 1;
                // } else {
                //     $proceso->doc_numero = +request('numero');
                //     if ($recibo->actual < +request('numero'))
                //         $recibo->actual = +request('numero') + 1;
                // }

                $numero_doc = +request('numero');
                if ($numero_doc >= $recibo->actual){

                    if ($numero_doc > $recibo->actual){
                        $proceso->doc_numero = $numero_doc;
                        $recibo->actual = $numero_doc + 1;
                    } else {
                        $proceso->doc_numero = $recibo->actual;
                        $recibo->actual += 1;
                        $recibo->save();
                    }
                } else {
                    $proceso->doc_numero = $numero_doc;
                    // if ($guia->actual < +$numero_doc)
                    // $next_numero = $numero_doc + 1;
                    // if (Despacho::existe_numero(+request('comprobante'), $next_numero))
                    // $guia->actual = +$numero_doc + 1;
                }

                // $recibo->actual += 1;
                // $recibo->save();
                //fin incremento
                $proceso->fecha_emision = request('fecha');
                $proceso->fecha_llegada = request('fecha_detalle');
                $proceso->motivo = 'none';
                $proceso->modo = 'recibo';
                $proceso->observacion = request('observacion');
                if (request('destino') == 0) { //agregar nueva locacion
                    $pre_locacion = PropietariosLocacion::existeLocacion($cliente->ent_id, request('destino_nombre'));
                    if ($pre_locacion == null) {
                        $locacion = new PropietariosLocacion();
                        $locacion->entidad_id = $cliente->ent_id;
                        $locacion->locacion = strtoupper(request('destino_nombre'));
                        $locacion->predeterminado = '0';
                        $locacion->save();

                        $proceso->destino_id = $locacion->elo_id;
                        $proceso->destino_nombre = $locacion->locacion;
                    } else {
                        $proceso->destino_id = $pre_locacion->elo_id;
                        $proceso->destino_nombre = $pre_locacion->locacion;
                    }



                } else {
                    $proceso->destino_id = request('destino');
                    $proceso->destino_nombre = request('destino_nombre');
                }

                $proceso->total_cilindros = request('total_cilindros');
                $proceso->total_presion = request('total_presion');
                $proceso->total_cubicos = request('total_cubicos');
                $proceso->doc_referencia = request('referencia');
                $proceso->entidad_id = $cliente->ent_id;
                $proceso->save();

                //registrar cilindros y cambiar estado
                // $res['produccion_id']  = $produccion->pro_id;

                $send = collect();

                $send_seguimiento = [];
                $cilindros_id = [];
                $situacion = Cilindro::getSituacion('fabrica');
                $estado = Cilindro::getEstado('vacio');
                $evento = 'vacio';
                foreach (request('cilindros') as $cil) {
                    $cilindros_id[] = $cil['id'];
                    // $cilindro_temp = Cilindro::find($cil['id']);
                    //jalar del mismo o solo
                    $send[] = [
                        'despacho_id' => $proceso->des_id,
                        'cilindro_id' => $cil['id'],
                        'des_capacidad' => $cil['capacidad'],
                        'des_presion' => $cil['cantidad'],
                        'des_cubico' => $cil['capacidad'],
                        'propietario_id' => $cil['propietario_id'],
                        'propietario_nombre' => $cil['propietario'],
                        'cilindro_serie' => $cil['serie'],
                        'cilindro_codigo' => $cil['codigo'],
                        'observacion' => $cil['observacion'],
                        // 'motivo' => $cil['motivo'],
                        'cilindro_tapa' => ''.$cil['tapa'].'',
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                    $orden_seg = 1;
                    if (CilindroSeguimiento::existe_en_fecha($cil['id'], request('fecha'))) {
                        $orden_seg = CilindroSeguimiento::extraer_nuevo_orden($cil['id'], request('fecha'));
                    }
                    $send_seguimiento[] = [
                        'cilindro_id' => $cil['id'],
                        'created_at' => $now,
                        'updated_at' => $now,
                        'orden_seg' => $orden_seg,
                        'evento' => 'vacio',
                        'descripcion' => 'Cilindro ingresado a fábrica',
                        'referencia_id' => $proceso->des_id,
                        'origen' => 'app',
                        'fecha' => request('fecha'),
                        'fecha_detalle' => request('fecha_detalle')
                    ];

                    // $cilindro->cargado = 2;
                    // $cilindro
                    // $cilindro->situación = 2;
                    if (request('anular') != '1') {
                        $cilindro_temp = Cilindro::find($cil['id']);
                        $cilindro_temp->situacion = $situacion;
                        $cilindro_temp->cargado = $estado;
                        $cilindro_temp->evento = $evento;
                        $cilindro_temp->recibo_id_entrada = $proceso->des_id;

                        // Cilindro::whereIn('cil_id', $cilindros_id)->update([
                        // 'situacion' => $situacion,
                        // 'cargado' => $estado,
                        // 'evento' => $evento
                        // ]);//
                        $salida = CilindrosEntradaSalida::getDespachoSalida($cil['id'], $cilindro_temp->despacho_id_salida);
                        $cilindro_temp->save();
                        if ($salida) {
                            //complementa la salida con la entrada actual
                            $salida->entrada = request('fecha');
                            $salida->recibo_id = $proceso->des_id;
                            $salida->observacion_entrada = $cil['observacion'];
                            $salida->completado = '1';
                            $salida->save();
                        } else {

                            $entrada = new CilindrosEntradaSalida();
                            $entrada->entrada = request('fecha');
                            $entrada->salida = request('fecha');
                            $entrada->observacion_salida = 'SIN INFORMACIÓN SOBRE SALIDA';
                            $entrada->cilindro_id = $cil['id'];
                            $entrada->recibo_id = $proceso->des_id;
                            $entrada->observacion_entrada = $cil['observacion'];
                            $entrada->completado = '1';
                            $entrada->save();

                        }
                    }
                }
                if (request('anular') != '1') {
                    //CAMBIAR SITUACION DE CILINDRO A -> FABRICA

                    // Cilindro::whereIn('cil_id', $cilindros_id)->update([
                    //     'situacion' => $situacion,
                    //     'cargado' => $estado,
                    //     'evento' => $evento
                    //     ]);//
                    CilindroSeguimiento::insert($send_seguimiento);



                }
                if ($send->count() > 0)
                    DespachoCilindros::insert($send->toArray());
            });
            // $res['detalles'] = $produccion->detalles;
            $res['success'] = true;
        }


        return response()->json($res);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        if ($id == 'datatable') {
            // $all = collect();
            // DB::enableQueryLog();
            // $name_code = '';
            // if ($request->filled('m')) {
            //     switch (request('m')) {
            //         case 'despacho':
            //             $name_code = 'guia';
            //             break;
            //         case 'recibo':
            //             $name_code = 'recibo';
            //             break;
            //     }
            // }


            // if (($code = Comprobante::getCode($name_code)) != 'undefined') {
            //     $all = Despacho::getAllByProceso($code)->get()->map(function ($item) {
            //         $item->destino->entidad;
            //         $item->guia->negocio;
            //         $item->doc_numero = fill_zeros($item->doc_numero);
            //         return $item;
            //     });
            // } else {
            //     $all = Despacho::all()->map(function ($item) {
            //         $item->destino->entidad;
            //         $item->guia->negocio;
            //         $item->doc_numero = fill_zeros($item->doc_numero);
            //         return $item;
            //     });
            // }
            // $query = DB::getQueryLog();
            // return response()->json(ProduccionResource::collection($all));
        } else {
            $despacho = Despacho::find($id);
            // $despacho->fecha = Carbon::createFromFormat('Y-m-d', $despacho->fecha)->format('d/m/y');

            // $dd = new ProduccionResource($despacho);
            // return response()->json($dd);
            $data['success'] = false;
            if ($despacho) {
                $data['despacho'] = $despacho;
                $data['documento'] = $despacho->documento;
                $data['titulo_pagina'] = 'RECIBO, '.$despacho->documento->cne_attr.'-'.$despacho->doc_serie.'-'.fill_zeros($despacho->doc_numero);
                $data['destino'] = $despacho->destino;
                $data['cilindros'] = $despacho->detalles;
                $data['entidad'] = $despacho->destino->entidad;
                $data['success'] = true;
            }
            // $data['despacho'] = $despacho;
            return view('home.recibo.detalles', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $negocios = Negocio::all();
        $despacho = Despacho::find($id);
        $data['no_encontrado'] = $despacho == null;
        $data['edit'] = true;
        $data['recibo_doc'] = $despacho;

        if (!$data['no_encontrado']) {
            $despacho->detalles->map(function($item) {
                $item->propietario;
                return $item;
            });
            $despacho->destino->entidad->documento;
            $despacho->destino->entidad->locaciones;
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
            // dd($negocios[0]->recibos);
            $data['negocios'] = $negocios;
            // dd($negocios);


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
                if ($sis->recibos->count() > 0) {
                    $comprobante = $sis->recibos[0];
                    // dd($comprobante);
                    if ($comprobante != null) {
                        $data['js']['comprobante_success'] = true;
                        $data['js']['comprobante'] = $despacho->documento_id;
                        $data['js']['serie_comprobante'] = $despacho->doc_serie;
                        // $data['js']['numero_comprobante'] = fill_zeros(8232323232329);
                        $data['js']['numero_comprobante'] = fill_zeros($despacho->doc_numero);
                    }
                }
                // $comprobante = $sis->getDocumentoActivo('guia');
                // dd($sis);

            }
        }
        // dd($data['js']);
        // dd($data);
        // return response()->json($data);
        $data['titulo_pagina'] = 'Recibo - Editar';
        return view('home.recibo.registro', $data);
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
        $res = ['success' => false, 'show_message' => false, 'msg' => ''];
        if ($request->filled('metodo')) {
            $despacho = Despacho::find($id);
            if ($despacho) {
                // dd($request);
                //se asume que 'despacho' es el recibo
                DB::transaction(function () use ($despacho, $request, &$res) {
                    $now = Carbon::now();
                    $metodo = request('metodo');
                    switch ($metodo) {
                        //utiliado al editar recibo
                        case 'modificar_recibo':
                            $valida = $request->validate([
                                'negocio' => 'required',
                                'comprobante' => 'required',
                                'anular' => 'required',
                                'serie' => 'required',
                                'numero' => 'required',
                                'fecha' => 'required',
                                'fecha_detalle' => 'required',
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
                                    $res['msg'] = 'El número de recibo se encuentra registrado';
                                }
                            }
                            if ($procesa && $guia && $guia->negocio->neg_id == $negocio->neg_id) {

                                    // $despacho = new Despacho();
                                    $despacho->documento_id = $guia->cne_id;
                                    $despacho->doc_nombre = $guia->nombre;
                                    $despacho->anulado = request('anular', '0');
                                    $despacho->doc_serie = $guia->serie;

                                    $despacho->entidad_id = request('cliente');

                                    // $despacho->salida = '1';
                                    // $despacho->fecha_salida = request('fecha');

                                    // $despacho->llegada = '1';
                                    $despacho->fecha_llegada = request('fecha_detalle');

                                    // $despacho->confirmada = '1';
                                    // $despacho->fecha_confirmada = request('fecha');

                                    $despacho->doc_referencia = request('referencia', '');
                                    //incrementar el correlativo

                                    $despacho->doc_numero = +request('numero');
                                    // $guia->actual = +request('numero') + 1;



                                    // $guia->save();
                                    //fin incremento°!
                                    $despacho->fecha_emision = request('fecha');
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
                                    $registrar_ids = [];
                                    $send_seguimiento = [];
                                    $send_entrada_salida = [];
                                    $send_seguimiento_salida = [];
                                    $send_seguimiento_llegada = [];
                                    $now = Carbon::now();
                                    $cilindros_id = [];
                                    $cilindros_actuales = $despacho->detalles;
                                    $cilindros_id_actuales = $despacho->detalles->map(function($item) {
                                        return $item->cilindro_id;
                                    });
                                    $eliminar_id = [];
                                    $actualizar_id = [];

                                    foreach (request('cilindros') as $cil) {
                                        $cilindros_id[] = $cil['id'];
                                    }
                                    foreach ($cilindros_id_actuales as $key => $value) {
                                        if (in_array($value, $cilindros_id)) {
                                            $actualizar_id[] = $value;
                                        } else {
                                            $eliminar_id[] = $value;
                                        }
                                    }
                                    //eliminar

                                    foreach ($eliminar_id as $key => $value) {
                                        // $despacho->detalles->where('cilindro_id', $value)->where('despacho_id', $despacho->des_id)->first()->delete();

                                        // CilindroSeguimiento::eliminar($value, 'despacho', $despacho->des_id, 'app');
                                        // CilindroSeguimiento::eliminar($value, 'transporte', $despacho->des_id, 'app');
                                        // CilindroSeguimiento::eliminar($value, 'cliente', $despacho->des_id, 'app');


                                        // CilindrosEntradaSalida::where('cilindro_id', $value)->where('guia_id', $despacho->des_id)->first()->delete();

                                        // //no se regresa a un estado previo en editar?
                                        // $eventos = CilindroSeguimiento::where('cilindro_id', $value)->whereIn('evento', ['vacio', 'cargando', 'cargado', 'despacho', 'transporte', 'cliente'])->where('fecha', '>=', $despacho->fecha_emision)->get();
                                        // if ($eventos->count() == 0) {
                                        //     //modificar el estado del cilindro
                                        //     $cilindro = Cilindro::find($value);
                                        //     $cilindro->situacion = Cilindro::getSituacion('fabrica');
                                        //     $cilindro->cargado = Cilindro::getEstado('cargado');
                                        //     $cilindro->evento = 'cargado';
                                        //     $cilindro->despacho_id_salida = 0;
                                        //     $cilindro->save();
                                        // }

                                    }
                                    $situacion_up = Cilindro::getSituacion('fabrica');
                                    $estado_up = Cilindro::getEstado('vacio');
                                    $evento_up = 'vacio';

                                    foreach (request('cilindros') as $cil) {
                                        // $cilindro = Cilindro::find($cil['id']);

                                        //jalar del mismo o solo
                                        $registra = true;
                                        // foreach ($actualizar_id as $key => $value) {
                                        if ($cil['registrado'] == 1 && in_array($cil['id'], $actualizar_id)) {
                                            //actualizar
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
                                                        'fecha' => request('fecha')
                                                    ]);

                                                CilindrosEntradaSalida::where('cilindro_id', $cil['id'])
                                                    ->where('guia_id', $despacho->des_id)
                                                    ->update([
                                                        'salida' => request('fecha'),
                                                        'observacion_salida' => $cil['observacion']
                                                    ]);


                                                $registra = false;
                                            }
                                            // break;
                                        }
                                        // }
                                        // $cilindros_id[] = $cil['id'];
                                        // if ($registra) {
                                        // dd($cil);
                                        if ($cil['registrado'] == 0) {
                                            $registrar_ids[] = $cil['id'];
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
                                                'evento' => 'vacio',
                                                'descripcion' => 'CILINDRO INGRESADO A FÁBRICA',
                                                'referencia_id' => $despacho->des_id,
                                                'origen' => 'app',
                                                'fecha' => request('fecha'),
                                                'fecha_detalle' => request('fecha_detalle')
                                            ];


                                            if (request('anular') != '1') {
                                                $cilindro_temp_up = Cilindro::find($cil['id']);
                                                $cilindro_temp_up->situacion = $situacion_up;
                                                $cilindro_temp_up->cargado = $estado_up;
                                                $cilindro_temp_up->evento = $evento_up;
                                                $cilindro_temp_up->recibo_id_entrada = $despacho->des_id;

                                                $salida_upd = CilindrosEntradaSalida::getDespachoSalida($cil['id'], $cilindro_temp_up->despacho_id_salida);
                                                $cilindro_temp_up->save();
                                                if ($salida_upd) {
                                                    //complementa la salida con la entrada actual
                                                    $salida_upd->entrada = request('fecha');
                                                    $salida_upd->recibo_id = $despacho->des_id;
                                                    $salida_upd->observacion_entrada = $cil['observacion'];
                                                    $salida_upd->completado = '1';
                                                    $salida_upd->save();
                                                } else {
                                                    $send_entrada_salida[] = [
                                                        'entrada' => request('fecha'),
                                                        'salida' => request('fecha'),
                                                        'observacion_salida' => 'SIN INFORMACIÓN SOBRE SALIDA',
                                                        'cilindro_id' => $cil['id'],
                                                        'recibo_id' => $despacho->des_id,
                                                        'observacion_entrada' => $cil['observacion'],
                                                        'completado' => '1',
                                                        'created_at' => Carbon::now(),
                                                        'updated_at' => Carbon::now(),
                                                    ];
                                                }
                                            }

                                        }

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

                                        // Cilindro::whereIn('cil_id', $registrar_ids)->update([
                                        //     'recibo_id_entrada' => $despacho->des_id,
                                        //     'evento' => 'vacio'
                                        // ]);
                                        // dd($send_seguimiento);
                                        if (count($send_seguimiento) > 0)
                                            CilindroSeguimiento::insert($send_seguimiento);
                                        if (count($send_entrada_salida) > 0)
                                            CilindrosEntradaSalida::insert($send_entrada_salida);


                                        //seguimiento ara salida y llegada

                                    }
                                    if (count($send) > 0)
                                        DespachoCilindros::insert($send);




                                // $res['detalles'] = $produccion->detalles;
                                $res['success'] = true;
                            }



                            break;
                    }
                });
            }
        }
        return response()->json($res);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      
			$res = ['success' => false];
			$objDes = Despacho::find($id);
			
			if ($objDes) {
				DB::transaction(function () use($objDes, &$res) {	
						$objDes->detalles->map(function($item) use($objDes) {
								$cil = $item->cilindro;
								$cil->situacion = Cilindro::getSituacion('cliente');
								$cil->cargado = '2';
								$cil->evento = 'cliente';
								$cil->despacho_id_salida = 0;
								$cil->recibo_id_entrada = 0;
								$cil->save();
								// $cilindro->defectuoso = 1;

								// $entr_salida = CilindrosEntradaSalida::getByDespachoAndCilindro($cil->cil_id, $objDes->des_id);
								// if ($entr_salida->completado == 0) {
								// 	$entr_salida->delete();
								// }

								//agregar seguimiento
								
								$seg = new CilindroSeguimiento();
								$seg->cilindro_id = $cil->cil_id;
								$orden_seg = 1;
								if (CilindroSeguimiento::existe_en_fecha($cil->cil_id, now()->format('Y-m-d'))) {
												$orden_seg = CilindroSeguimiento::extraer_nuevo_orden($cil->cil_id, now()->format('Y-m-d'));
								}
								$seg->orden_seg = $orden_seg;
								$seg->evento = 'eliminado_recibo';
								$seg->descripcion = 'RECIBO ELIMINADO '.now()->format('Y-m-d H:i:s');
								$seg->referencia_id = $objDes->des_id;
								$seg->origen = 'app';
								$seg->forzado = '1';
								$seg->fecha = now()->format('Y-m-d');
								$seg->fecha_detalle = now()->format('Y-m-d H:i:s');
								$seg->save();
						});
						$objDes->eliminado = 1;
						if (strlen(trim($objDes->observacion)) == 0) {
							$objDes->observacion = 'ELIMINADO '.now()->format('Y-m-d H:i:s');
						} else {
							$objDes->observacion .= ', ELIMINADO '.now()->format('Y-m-d H:i:s');
						}

						//agregar seguimiento
						
						$objDes->save();
						$res['success'] = true;
				});
			}
			return response()->json($res);
    }
}
