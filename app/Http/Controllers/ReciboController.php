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
        $data['titulo_pagina'] = 'Recibo - Listar';
        return view('home.recibo.listar', $data);
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
        $data['titulo_pagina'] = 'Recibo - Crear';
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
            'motivo' => 'required',
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
                if (+request('numero') == $recibo->actual){
                    $proceso->doc_numero = $recibo->actual;
                    $recibo->actual += 1;
                } else {
                    $proceso->doc_numero = +request('numero');
                    if ($recibo->actual < +request('numero'))
                        $recibo->actual = +request('numero') + 1;
                }
                // $recibo->actual += 1;
                $recibo->save();
                //fin incremento
                $proceso->fecha_emision = request('fecha');
                $proceso->fecha_llegada = request('fecha');
                $proceso->motivo = strtoupper(request('motivo'));
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
                        'motivo' => $cil['motivo'],
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
                        'fecha_detalle' => request('fecha')
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
        //
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
