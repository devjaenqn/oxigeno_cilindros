<?php

namespace App\Http\Controllers;


use App\Cilindro;
use App\CilindroSeguimiento;
use App\Http\Resources\ProduccionResource;
use App\Http\Resources\SistemaResource;
use App\Lote;
use App\Operador;
use App\Produccion;
use App\ProduccionCilindros;
use App\Sistema;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class ProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->has('type'))
            switch(request('type')){
                case 'json':
                    $all = [];
                    return response()->json($all);
                    break;
                default:
                    abort(404);
                    break;
            }
        else {
            $data['titulo_pagina'] = 'Producción - Listar';
            return view('home.produccion.listar', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['edit'] = false;
        $data['name'] = 'jaen';
        $data['operadores'] = Operador::all();
        // $sistemas = Sistema::where('attr', 's')->get();
        $sistemas = Sistema::all();
        $sistemas->map(function ($item) {
            if ($item->lote != null)
                $item->lote->actual = fill_zeros($item->lote->actual);
            return $item;
        });
        $data['sistemas'] = $sistemas;


        // $data['lote'] = Lote::active()->get();
        $data['js'] = [
            'data_sistemas' => SistemaResource::collection($sistemas),
            'sistema' => 0,
            'serie_lote' => '',
            'lote_success' => false,
            'numero_lote' => '',
            // 'data_lotes' => $sistemas->map(function ($item) {

            //     // return $item->lote;
            // })->toArray()
        ];
        if ($sistemas->count() > 0) {
            $sis = $sistemas[0];
            // dd($sis);
            $data['js']['sistema'] = $sis->sis_id;
            if ($sis->lote != null) {
                $data['js']['serie_lote'] = $sis->lote->serie;
                $data['js']['lote_success'] = true;
                $data['js']['numero_lote'] = $sis->lote->actual;
            }
        }
        // dd($data['js']);
        $data['titulo_pagina'] = 'Porduccion - Crear';
        return view('home.produccion.registro', $data);
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
            'entrada' => 'required',
            'salida' => 'required',
            'cilindros' => 'required',
            'operador' => 'required',
            'fecha' => 'required',
            'sistema' => 'required'
        ]);

          // $this->validate($request, );
        // dd($request);

        $res = ['success' => false];
        // $res['data'] = $request;
        // return response()->json($res);
        // return response()->json($request);
        //obtener el numero de lote
        $operador = Operador::find(request('operador'));
        $sistema = Sistema::find(request('sistema'));

        if ($sistema->lote && $operador) {
            DB::transaction(function () use ($sistema, $operador) {

                $produccion = new Produccion();

                $produccion->sistema_lote = $sistema->lote->sistema->sistema;
                $produccion->numero_lote = $sistema->lote->actual;
                $produccion->serie_lote = $sistema->lote->serie;
                //incrementar el correlativo
                $sistema->lote->actual += 1;
                $sistema->lote->save();

                $produccion->lote_id = $sistema->lote->lot_id;
                $produccion->entrada = request('entrada');
                $produccion->salida = request('salida');
                $produccion->operador_id = request('operador');
                $produccion->operador_nombre = strtoupper($operador->nombre.' '.$operador->apellidos);
                $produccion->fecha = request('fecha');
                $produccion->finalizado = '1';
                $produccion->turno = strtoupper(request('turno'));
                $produccion->observacion = strtoupper(request('observacion'));
                $produccion->total_cilindros = request('total_cilindros');
                $produccion->total_presion = request('total_libras');
                $produccion->save();

                //registrar cilindros y cambiar estado
                // $res['produccion_id']  = $produccion->pro_id;
                $send_produccion_cilindros = [];
                // $send_seguimiento = collect();
                $send_seguimiento = [];
                $cilindros_id = [];
                $cilindros_id_retiro = [];
                $cilindros_retirados = [];
                $now = Carbon::now();
                foreach (request('cilindros') as $cil) {
                    // $cilindro = Cilindro::find($cil['id']);

                    if ($cil['retiro'] == '1') {
                        $cilindros_id_retiro[] = $cil['id'];
                        $cilindros_retirados[] = ['id' => $cil['id'], 'salida' => $cil['salida']];
                    } else {
                        $cilindros_id[] = $cil['id'];
                    }
                    //jalar del mismo o solo
                    $send_produccion_cilindros[] = [
                        'produccion_id' => $produccion->pro_id,
                        'cilindro_id' => $cil['id'],
                        'pro_capacidad' => $cil['capacidad'],
                        'pro_presion' => $cil['cantidad'],
                        'propietario_name' => $cil['propietario'],
                        'propietario_id' => $cil['propietario_id'],
                        'cilindro_serie' => $cil['serie'],
                        'cilindro_codigo' => $cil['codigo'],
                        'created_at' => $cil['ingreso'],
                        'updated_at' => $cil['salida'],
                        'ingreso' => $cil['ingreso'],
                        'salida' => $cil['salida'],
                        'retiro' => $cil['retiro'],
                        'observacion' => $cil['observacion']
                    ];
                    $orden_seg = 1;
                    if (CilindroSeguimiento::existe_en_fecha($cil['id'], request('fecha'))) {
                        $orden_seg = CilindroSeguimiento::extraer_nuevo_orden($cil['id'], request('fecha'));
                    }
                    //ingreso a sistema (motor)
                    $send_seguimiento[] = [
                        'cilindro_id' => $cil['id'],
                        'created_at' => $now,
                        'updated_at' => $now,
                        'orden_seg' => $orden_seg,
                        'evento' => 'cargando',
                        'descripcion' => 'Cargando, lote producción',
                        'referencia_id' => $produccion->pro_id,
                        'origen' => 'app',
                        'fecha' => request('fecha'),
                        'fecha_detalle' => $cil['ingreso']
                    ];
                    //finaliza carga
                    $send_seguimiento_finaliza[] = [
                        'cilindro_id' => $cil['id'],
                        'created_at' => $now,
                        'updated_at' => $now,
                        'orden_seg' => $orden_seg,
                        'evento' => 'cargado',
                        'descripcion' => 'Cargado, lote producción finalizado',
                        'referencia_id' => $produccion->pro_id,
                        'origen' => 'app',
                        'fecha' => request('fecha'),
                        'fecha_detalle' => $cil['salida']
                    ];
                }

                // $cilindros_id = $send->map(function ($item) {
                //         return $item['cilindro_id'];
                // });


                //marcar cargando
                ProduccionCilindros::insert($send_produccion_cilindros);

                Cilindro::whereIn('cil_id', $cilindros_id + $cilindros_id_retiro)->update([
                    'cargado' => Cilindro::getEstado('cargando'),
                    'evento' => 'cargando',
                    'updated_at' => request('entrada')
                ]);

                CilindroSeguimiento::insert($send_seguimiento);

                $estado = Cilindro::getEstado('cargado');
                Cilindro::whereIn('cil_id', $cilindros_id)->update([
                    'cargado' => $estado,
                    'evento' => 'cargado',
                    'updated_at' => $now
                ]);

                foreach ($cilindros_retirados as $value) {

                    Cilindro::where('cil_id', $value['id'])->update([
                        'cargado' => $estado,
                        'evento' => 'cargado',
                        'updated_at' => $now
                    ]);
                }
                CilindroSeguimiento::insert($send_seguimiento_finaliza);
                // $res['detalles'] = $produccion->detalles;
            });
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
            // $all = Produccion::all();
            // $all->map(function($item) {
            //     $item->numero_lote = fill_zeros($item->numero_lote);
            //     return $item;
            // });
            // return response()->json(ProduccionResource::collection($all));
            // DB::enableQueryLog();
            $all = Produccion::with(['operador', 'detalles'])
                ->join('operador', 'operador.ope_id', '=', 'produccion.operador_id')
                ->join('produccion_cilindros', 'produccion_cilindros.produccion_id', '=', 'produccion.pro_id')
                ->selectRaw('distinct produccion.*, operador.nombre, operador.apellidos');
                    // return datatables()->of(CilindroResource::collection($all))->toJson();
            $make = DataTables::of($all)
                    ->filter(function ($query) use ($request) {
                        if ($request->has('buscar')) {
                            if (request('buscar') != '') {
                                $query->where( function( $query ) use($request) {
                                    $query->where('numero_lote', 'like', "%{$request->buscar}%");
                                    $query->orWhere('cilindro_serie', 'like', "%{$request->buscar}%");
                                    $query->orWhere('cilindro_codigo', 'like', "%{$request->buscar}%");
                                    $query->orWhere('nombre', 'like', "%{$request->buscar}%");
                                    $query->orWhere('apellidos', 'like', "%{$request->buscar}%");
                                });
                                // $query->operador()->where
                            }


                            // $query->orWhere('numero_lote', 'like', "%{$custom['query']}%");
                            // $query->orWhere('cilindro', 'like', "%{$custom['query']}%");
                        }

                        if ($request->has('filtro_date') && $request->has('desde') && $request->has('hasta')) {
                            if ($request->filtro_date == 'interval') {
                                $query->where('fecha', '>=', $request->desde);
                                $query->where('fecha', '<=', $request->hasta);
                            }
                            if ($request->filtro_date == 'same') {
                                $query->where('fecha', '=', $request->desde);
                            }
                        }

                        // $custom = $request->custom_filter;
                        //     if (isset($custom['query']) && trim($custom['query']) != '') {

                        //     }
                        //     $query->whereIn('situacion', $custom['situacion']);




                    })
                    ->editColumn('numero_lote', '{{ fill_zeros($numero_lote) }}');

            // $query = DB::getQueryLog();
            // dd($query);
            return $make
                    ->make(true);

        } else {
            $produccion = Produccion::find($id);
            $produccion->numero_lote = fill_zeros($produccion->numero_lote);
            // $produccion->hora_entrada = Carbon::createFromFormat('Y-m-d H:i:s', $produccion->entrada)->format('h:i A');
            $produccion->fecha_entrada = Carbon::createFromFormat('Y-m-d H:i:s', $produccion->entrada)->format('d/m/y h:i A');
            $produccion->fecha_salida = Carbon::createFromFormat('Y-m-d H:i:s', $produccion->salida)->format('d/m/y h:i A');
            // $produccion->hora_salida = Carbon::createFromFormat('Y-m-d H:i:s', $produccion->salida)->format('h:i A');
            // $dd = new ProduccionResource($produccion);
            // return response()->json($dd);
            $data['edit'] = true;
            $data['sistemas'] = collect();
            $data['operadores'] = collect();
            $data['produccion'] = $produccion;
            $data['titulo_pagina'] = 'Produccion, '.$produccion->sistema_lote.', '.$produccion->serie_lote.'-'.$produccion->numero_lote;
            return view('home.produccion.detalles', $data);
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
        $res = ['success' => false];
        if ($request->filled('modo')) {
            $now = Carbon::now();
            switch (request('modo')) {
                case 'finalizar':
                    DB::transaction(function () use($now, $id, &$res) {
                        // DB::enableQueryLog();
                        $produccion = Produccion::find($id);
                        $produccion->finalizado = '1';
                        $produccion->save();

                        $cilindros = $produccion->detalles()->select('cilindro_id')->get();
                        // $send = $cilindros->map( function ($item) {
                        //     return $item->cilindro_id;
                        // });
                        $send_seguimiento = [];
                        $cilindros_id = [];
                        foreach ($cilindros as $cil) {
                            $cilindros_id[] = $cil->cilindro_id;
                            $send_seguimiento[] = [
                                'cilindro_id' => $cil->cilindro_id,
                                'created_at' => $now,
                                'updated_at' => $now,
                                'evento' => 'cargado',
                                'descripcion' => 'Cargado, lote producción finalizado',
                                'referencia_id' => $produccion->pro_id,
                                'origen' => 'app',
                                'fecha' => $now
                            ];
                        }

                        Cilindro::whereIn('cil_id', $cilindros_id)->update(['cargado' => Cilindro::getEstado('cargado')]);
                        CilindroSeguimiento::insert($send_seguimiento);
                        // $res['query'] = DB::getQueryLog();
                        $res['success'] = true;
                        $res['data'] = $produccion;
                    });
                    break;
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
    public function destroy($id)
    {
        //
    }
}
