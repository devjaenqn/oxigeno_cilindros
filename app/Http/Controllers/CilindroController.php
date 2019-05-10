<?php
namespace App\Http\Controllers;


use App\Cilindro;
use App\CilindroSeguimiento;
use App\CilindroTemporal;
use App\CilindrosEntradaSalida;
use App\Http\Resources\CilindroResource;
use App\Negocio;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class CilindroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request) {

      //$cilindros = Cilindro::all();

      //$pdf = PDF::loadView('home.cilindros.pdflistar', compact('cilindros'));
      //return $pdf->download('invoice.pdf');

        if ($request->filled('type')) {
            switch(request('type')){
                case 'json':
                    $all = Cilindro::with('propietario')->select()
                            ->join('entidades', 'cilindros.propietario_id', '=', 'entidades.ent_id');
                    // return datatables()->of(CilindroResource::collection($all))->toJson();
                    return DataTables::of($all)
                            ->filter(function ($query) use ($request) {
                                if ($request->has('custom_filter')) {
                                    $custom = $request->custom_filter;
                                    if (isset($custom['query']) && trim($custom['query']) != '') {
                                        $query->where(function($queryb) use ($custom) {
                                          $queryb->where('serie', 'like', "%{$custom['query']}%");
                                          $queryb->orWhere('entidades.nombre', 'like', "%{$custom['query']}%");
                                        });
                                    }
                                    $query->whereIn('situacion', $custom['situacion']);

                                }
                            })
                            ->make(true);
                    // return datatables()->of(CilindroResource::collection($xx))->toJson();


                    // return response()->json(CilindroResource::collection($all));
                    break;
                default:
                    abort(404);
                    break;
            }
        }

        if ($request->filled('q')) {
            $res = [];
            DB::enableQueryLog();
            $build = Cilindro::select()
                ->where('defectuoso', Cilindro::getEstado('optimo'))
                ->orderBy('serie', 'asc')
                ->where(function ($query) {
                    $query->where('serie', 'like', '%'.request('q').'%')
                        ->orWhere('codigo', 'like', '%'.request('q').'%');
                });

            if ($request->filled('m')) {
                switch (request('m')) {
                    case 'despacho':
                        //solo cargados y en fabrica
                        if ($request->cilindros != null && count($request->cilindros) > 0)
                              $build->whereNotIn('cil_id', $request->cilindros);
                        $build->where('cargado', Cilindro::getEstado('cargado'))
                            ->where('situacion', Cilindro::getSituacion('fabrica'))
                            ->where('evento', 'cargado');
                            // ->where('defectuoso', Cilindro::getEstado('optimo'));
                        break;
                    case 'produccion':
                        //solo vacio y en fabrica
                        // dd($_GET);
                        $build->where('cargado', Cilindro::getEstado('vacio'))
                            ->where('situacion', Cilindro::getSituacion('fabrica'));
                        // dd($request->cilindros);
                        if ($request->cilindros != null && count($request->cilindros) > 0)
                          $build->whereNotIn('cil_id', $request->cilindros);
                        $build->where( function ($query) {
                              $query->where('evento', 'create');
                              $query->orWhere('evento', 'vacio');
                            });
                            // ->where('defectuoso', Cilindro::getEstado('optimo'));
                        break;
                    case 'recibo':
                        //solo cargados y en cliente
                        if ($request->cilindros != null && count($request->cilindros) > 0)
                          $build->whereNotIn('cil_id', $request->cilindros);
                        $build->where('cargado', Cilindro::getEstado('cargado'))
                            ->where('evento', 'cliente')
                            ->where('situacion', Cilindro::getSituacion('cliente'));
                        break;
                    case 'editar':
                        if ($request->cilindros != null && count($request->cilindros) > 0)
                          $build->whereNotIn('cil_id', $request->cilindros);
                        break;
                    case 'all':
                        if ($request->cilindros != null && count($request->cilindros) > 0)
                          $build->whereNotIn('cil_id', $request->cilindros);
                        break;
                }
            }

            $res = $build->get();
            $cosa = DB::getQueryLog();
            // dd($cosa);
            // $res->makeHidden([
            //     'situacion',
            //     'cargado',
            //     'defectuoso']);

            // $res->map(function ($item, $key) {
            //     // $r = $item->propietario->nombre;
            //     // $item->propietario->makeHidden(['telefono', 'direccion', 'correo']);
            //     return $item;
            // });
            // $xx = $res->propietario->nombre;
            // $res->propietario->makeHidden(['telefono', 'direccion', 'correo']);
            $ress = CilindroResource::collection($res);
            // $res->propietario->toArray();
            // print_r($res);
            return response()->json($ress);
        }
        $data['titulo_pagina'] = 'CILINDRO LISTAR';
        return view('home.cilindros.listar', $data);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['edit'] = false;
        $data['titulo_pagina'] = 'CILINDRO REGISTRAR';
        return view('home.cilindros.registro', $data);
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
        'serie' => 'required',
        'capacidad' => 'required',
        'presion' => 'required',
        'tapa' => 'required',
        'propietario' => 'required',
        // 'hola' => 'required',
        // 'password' => 'required|min:6'
      ]);

      // $this->validate($request, );
      $res = ['success' => false, 'existe' => false];
      $cod = 201;
      $pre_cilindro = Cilindro::existeCodigo($request->propietario, $request->serie);
      // dd($request->tapa);
      // return response()->withError('Codigo registradp');
      if ($pre_cilindro == null) {
        // dd(request('serie'));
        DB::transaction(function () use(&$res, $request) {
          // DB::enableQueryLog();

          $cilindro = new Cilindro();
          $cilindro->serie = strtoupper($request->serie);
          $cilindro->codigo = strtoupper($request->serie);
          $cilindro->capacidad = $request->capacidad;
          $cilindro->tapa = request('tapa');
          $cilindro->presion = $request->presion;
          $cilindro->propietario_id = $request->propietario;
          $cilindro->situacion = "1";//en fabrica
          $cilindro->cargado = "0";//está vacia
          $cilindro->defectuoso = "0";//sin daños
          $cilindro->trasegada = "0";//no trasegada
          $cilindro->evento = "create";//listo para cargar
          // dd($cilindro->toSql());
          $cilindro->save();
          // dd(DB::getQueryLog());
          $seguimiento = new CilindroSeguimiento();

          $seguimiento->cilindro_id = $cilindro->cil_id;
          $seguimiento->evento = 'create';
          $seguimiento->descripcion = 'Cilindro creado';
          $seguimiento->referencia_id = $cilindro->cil_id;
          $seguimiento->origen = 'app';
          $seguimiento->fecha = Carbon::now();
          $seguimiento->fecha_detalle = Carbon::now();
          $seguimiento->save();

          // $seguimiento_vac = new CilindroSeguimiento();

          // $seguimiento_vac->cilindro_id = $cilindro->cil_id;
          // $seguimiento_vac->evento = 'vacio';
          // $seguimiento_vac->descripcion = 'Cilindro vacio';
          // $seguimiento_vac->referencia_id = $cilindro->cil_id;
          // $seguimiento_vac->origen = 'app';
          // $seguimiento_vac->fecha = Carbon::now();
          // $seguimiento_vac->save();

          $res['success'] = $cilindro != null;
          $res['data'] = $cilindro;


        });



      } else {
        $cod = 202;
        $res['existe'] = true;
        // abort(202, 'usuario registrado');
      }
      return response()->json($res, $cod);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $modo = 'default')
    {
      switch ($id) {
        case 'seguimiento_new':

          break;
        case 'seguimiento':
          // if ($request->ajax()) {
            $all = CilindrosEntradaSalida::with(['guia', 'recibo'])
                    ->select('cilindros_entrada_salida.*',
                      'doc.cne_attr',
                      'd.doc_nombre as guia_nombre',
                      'd.doc_numero as guia_numero',
                      'd.doc_serie as guia_serie',
                      'e.nombre as nombre_cliente_guia',
                      DB::raw('cs.orden_seg as orden_seg_des'),
                      DB::raw("IF(ISNULL(d.des_id), 0, 1) as order_helper_despacho"),
                      DB::raw("CONCAT(doc.cne_attr,'-',d.doc_serie,'-', d.doc_numero) as guia_correlativo"),
                      'dd.doc_nombre as recibo_nombre',
                      'dd.doc_numero as recibo_numero',
                      'dd.doc_serie as recibo_serie',
                      'ee.nombre as nombre_cliente_recibo',
                      DB::raw('css.orden_seg as orden_seg_rec'),
                      DB::raw("IF(ISNULL(dd.des_id), 0, 1) as order_helper_recibo"),
                      DB::raw("CONCAT(docr.cne_attr,'-',dd.doc_serie,'-', dd.doc_numero) as recibo_correlativo")
                    )
                    ->leftJoin('despacho as d' , 'cilindros_entrada_salida.guia_id', '=', 'd.des_id')
                    ->leftJoin('entidades as e' , 'e.ent_id', '=', 'd.entidad_id')
                    ->leftJoin('comprobantes_negocio as doc' , 'doc.cne_id', '=', 'd.documento_id')
                    ->leftJoin('cilindros_seguimiento as cs', function ($join) {
                      $join->on('cilindros_entrada_salida.cilindro_id', '=', DB::raw('cs.cilindro_id'))
                      ->where('cs.evento', '=', 'despacho')
                      ->where('cilindros_entrada_salida.guia_id', '=', DB::raw('cs.referencia_id'));
                    })
                    ->leftJoin('despacho as dd' , 'cilindros_entrada_salida.recibo_id', '=', 'dd.des_id')
                    ->leftJoin('entidades as ee' , 'ee.ent_id', '=', 'dd.entidad_id')
                    ->leftJoin('comprobantes_negocio as docr' , 'docr.cne_id', '=', 'dd.documento_id')
                    ->leftJoin('cilindros_seguimiento as css', function ($join) {
                      $join->on('cilindros_entrada_salida.cilindro_id', '=', DB::raw('css.cilindro_id'))
                      ->where('css.evento', '=', 'vacio')
                      ->where('css.referencia_id', '=', DB::raw('cilindros_entrada_salida.recibo_id'));
                    });
                    if ($request->filled('cilindro_id') && $request->cilindro_id != 0) {
                        $all->where('cilindros_entrada_salida.cilindro_id', $request->cilindro_id);
                    }
            $make = DataTables::of($all)
                    ->filter( function ($query) use($request) {
                      if ($request->filled('filtro_date') && $request->filled('desde') && $request->filled('hasta')) {
                          if ($request->filtro_date == 'interval') {
                            $query->where( function($query) use($request) {
                              $query->where( function($query) use($request) {
                                $query->where('cilindros_entrada_salida.salida', '>=', $request->desde);
                                $query->where('cilindros_entrada_salida.salida', '<=', $request->hasta);
                              });

                              $query->orWhere( function($query) use($request) {
                                $query->where('cilindros_entrada_salida.entrada', '>=', $request->desde);
                                $query->where('cilindros_entrada_salida.entrada', '<=', $request->hasta);
                              });
                            });
                          }
                          if ($request->filtro_date == 'same') {
                            $query->where( function($query) use($request) {
                              $query->where('cilindros_entrada_salida.salida', '=', $request->desde);
                              $query->orWhere('cilindros_entrada_salida.entrada', '=', $request->desde);
                            });
                          }
                      }
                      if ($request->filled('buscar') && trim($request->buscar) != '') {
                        $query->where( function($query) use ($request){
                          $query->where(DB::raw("CONCAT(d.doc_serie,'-', d.doc_numero)"), 'like', "%{$request->buscar}%");
                          $query->orWhere(DB::raw("CONCAT(dd.doc_serie,'-', dd.doc_numero)"), 'like', "%{$request->buscar}%");
                        });
                      }
                      // $query->orderBy('order_helper_despacho', 'asc');
                    });
            $mm = $make
              ->orderColumn('salida', 'salida $1, order_helper_despacho $1, orden_seg_des $1')
              ->orderColumn('entrada', 'entrada $1, order_helper_recibo $1, orden_seg_rec $1')
              ->editColumn('guia_correlativo', function($item) {
              // dd($item);
              if ($item->guia == null) {
                return $item->observacion_salida;
                // return 'NO DEFINIDO';
              } else {
                return $item->guia_correlativo;
              }
            });
            $mm = $mm->make(true);
            // dd($request);
            if ($request->has('export')) {
              $casa = [];
              $casa = $mm->original['data'];
              $cilindro = Cilindro::find(request('cilindro_id'));
              $data['rows'] = $casa;
              //considera negocio tempo como temporal
              $data['negocio'] = Negocio::find(2);
              $data['titulo'] = 'SEGUIMIENTO CILINDRO '.$cilindro->codigo;
              $pdf = PDF::loadView('home.cilindros.pdflistar', $data);
                  // $pdf = PDF::loadView('home.cilindros.pdfseguimiento', $data);
                  $pdf->setPaper('A4', 'landscape');
                  $pdf->setOptions(['dpi' => 250, 'fontHeightRatio' => 0.8]);

                  set_time_limit(60);
                  // dd($pdf);
                  return $pdf->stream('SEGUIMIENTO-CILINDRO_'.Carbon::now().'.pdf');
                  // return $pdf->download('listado.pdf');
              // dd($mm->original['data']);
            } else {

              return $mm;
            }
          // }
          break;

        default:
          $res = ['success' => false];
          $cod_res = 204;//no content
          if ($request->has('type') && $modo == 'default')
              switch(request('type')){
                  case 'json':
                      $cilindro = Cilindro::find($id);
                      if ($cilindro != null) {
                          $res['success'] = true;
                          // $res['data'] = CilindroResource::collection($cilindro);
                          $res['data'] = $cilindro;
                          $cod_res = 200;
                      }
                      return response()->json($res, $cod_res);
                      break;
                  default:
                      abort(404);
                      break;
              }
          else {
            $data['success'] = false;
            switch ($modo) {//modo de búsqueda
              case 'serie':
                $cilindro = Cilindro::getBySerie($id);
                $temp['cilindro'] = $cilindro;
                $temp['query'] = DB::getQueryLog();
                dd($temp);
                break;
              case 'seguimiento':
                // DB::enableQueryLog();
                $cilindro = Cilindro::find($id);
                $data = ['success' => false];
                if ($cilindro) {
                  $data['cilindro'] = $cilindro;
                  $data['detalles_cilindro'] = [];
                  if ($request->filled(['e', 'd', 'h', 'm'])) {
                    $detalles = $cilindro->entrada_salida()->orderBy('entrada', 'asc')->first();
                    for ($i=0; $i < 500; $i++) {
                      $data['detalles_cilindro'][] = $detalles;
                    }
                    // $detalles = CilindroSeguimiento::all();
                    // $detalless = CilindroSeguimiento::all();
                    // $data['detalles_cilindro'] = $detalles->toArray() + $detalless->toArray();
                    // dd($data['detalles_cilindro']);
                      // $data['detalles_cilindro'] = CilindroSeguimiento::all();
                      if ($request->e == 'xxx')
                        return view('home.cilindros.pdflistar', $data);
                      // PDF::setOptions(['dpi' => 300, 'fontHeightRatio' => 0.5]);
                      $pdf = PDF::loadView('home.cilindros.pdflistar', $data);
                      // $pdf = PDF::loadView('home.cilindros.pdfseguimiento', $data);
                      $pdf->setPaper('A4', 'landscape');
                      $pdf->setOptions(['dpi' => 250, 'fontHeightRatio' => 0.8]);

                      set_time_limit(60);
                      return $pdf->download('listado.pdf');

                  } else {
                    $data['success'] = true;
                    $seguimiento = $cilindro->seguimiento()->whereIn('evento', ['cliente', 'vacio'])->orderBy('fecha_date', 'desc')->get();
                    $resultado_forma = collect();
                    $helper = ['estado' => true];
                    $seguimiento->map(function($item) use(&$helper){
                      if ($helper['estado']) {
                        if ($item->evento == 'vacio') {
                          //create objet
                        }
                        if ($item->evento == 'cliente') {
                          //inicia otra fila
                        }
                      } else {
                        if ($item->evento == 'cliente') {
                          //botiene ultimo elemnto y lo agregar
                          //si no exite lo crea
                        }
                        if ($item->evento == 'vacio') {
                          //inicia nueva fila
                        }
                      }
                      $helper['estado'] = !$helper['estado'];
                    });

                    // dd($seguimiento);
                    // $data['cilindro'] = $cilindro;
                    $data['titulo_pagina'] = 'SEGUIMIENTO '.$cilindro->serie;
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
                    return view('home.cilindros.seguimiento', $data);
                  }

                }

                break;
              case 'cambiar_situacion':
                $cilindro = Cilindro::find($id);

                $data['titulo_pagina'] = 'Elemento no encontrado';
                if ($cilindro) {
                  $data['cilindro'] = $cilindro;
                  $data['success'] = true;
                  $selected = [
                    'cliente' => false,
                    'trasegada' => false,
                    'defectuosa' => false,
                    'cargada' => false,
                    'vacio' => false
                  ];

                  $situacion = [];
                  $process_eventos = true;
                  if ($cilindro->defectuoso == '1') {
                    $selected['defectuosa'] = true;
                    $process_eventos = fals3;
                  }
                  if ($cilindro->trasegada == '1') {
                    $selected['trasegada'] = true;
                    $process_eventos = false;
                  }
                  if ($process_eventos) {
                    switch ($cilindro->evento) {
                      case 'cliente':
                        $selected['cliente'] = true;
                        break;
                      case 'vacio':
                        $selected['vacio'] = true;
                        break;
                      case 'cargado':
                        $selected['cargado'] = true;
                        break;
                    }
                  }
                  $data['selected'] = $selected;
                  // dd($cilindro);
                  $data['situacion'] = $situacion;
                }
                $data['titulo_pagina'] = 'CAMBIAR SITUACIÓN';
                if ($cilindro)
                  $data['titulo_pagina'] .= ', '.$cilindro->serie;
                return view('home.cilindros.cambiarsituacion', $data);
                break;
              case 'rastros':
                $cilindro = Cilindro::find($id);
                // dd($cilindro->getEventosFecha()->get());
                // $eventos = CilindroSeguimiento::all();
                // $eventos = $cilindro->getEventosFecha()->get();
                echo '<h3>'.$cilindro->serie.'</h3></br>';
                $eventos = $cilindro->seguimiento()->orderBy('fecha_date', 'asc')->orderBy('orden', 'asc')->get();
                echo "<table  style='border:1px solid black'><thead><tr><th>ID</th><th>CREATED</th><th>UPDATED</th><th>EVENTO</th><th>DES</th><th>REF_ID</th><th>ORI</th><th>FECHA</th><th>FECHA_DETALLE</th><th>FORZADO</th></tr></thead><tbody>";
                $table = '';
                foreach ($eventos as $key => $value) {

                  $table .= "<tr>
                          <td style='border:1px solid black'>$value->cis_id</td>
                          <td style='border:1px solid black'>$value->created_at</td>
                          <td style='border:1px solid black'>$value->updated_at</td>
                          <td style='border:1px solid black'>$value->evento</td>
                          <td style='border:1px solid black'>$value->descripcion</td>
                          <td style='border:1px solid black'>";
                          if ($value->referencia_id != 0) {
                            if ($value->evento == 'cargado')
                              $table .= '<a href="'.url('home/produccion/'.$value->referencia_id).'">'.$value->referencia_id.'</a>';
                            else if ($value->evento == 'despacho' || $value->evento == 'cliente')
                              $table .= '<a href="'.url('home/despacho/'.$value->referencia_id).'">'.$value->referencia_id.'</a>';
                            else if ($value->evento == 'vacio')
                              $table .= '<a href="'.url('home/recibo/'.$value->referencia_id).'">'.$value->referencia_id.'</a>';
                            else if ($value->evento == 'eliminado_produccion')
                              $table .= '<a href="'.url('home/produccion/'.$value->referencia_id).'">'.$value->referencia_id.'</a>';
                            else if ($value->evento == 'eliminado_despacho')
                              $table .= '<a href="'.url('home/despacho/'.$value->referencia_id).'">'.$value->referencia_id.'</a>';
                            else if ($value->evento == 'eliminado_recibo')
                              $table .= '<a href="'.url('home/recibo/'.$value->referencia_id).'">'.$value->referencia_id.'</a>';
                          } else {
                            $table .= $value->referencia_id;
                          }

                  $table .= "</td>
                          <td style='border:1px solid black'>$value->origen</td>
                          <td style='border:1px solid black'>$value->fecha</td>
                          <td style='border:1px solid black'>$value->fecha_detalle</td>
                          <td style='border:1px solid black'>$value->forzado</td>
                        </tr>";

                }
                echo $table;
                echo "</tbody></table>";
                exit;
                break;
              case 'seguimiento_old':
                $cilindro = Cilindro::find($id);
                if ($cilindro) {
                  $data['cilindro'] = $cilindro;
                  $data['titulo_pagina'] = $cilindro->serie.' - Seguimiento';
                  if ($request->filled('type')) {
                    // $seguimiento = $cilindro->seguimiento()->orderBy('fecha', 'asc')->orderBy('orden_seg', 'asc')->orderBy('orden', 'asc')->get()->map(function($item) {
                    //   $item->referencia;
                    //   if ($item->referencia) {
                    //     $item->referencia->doc_numero = fill_zeros($item->referencia->doc_numero);
                    //   }
                    //   return $item;
                    // });
                    $seguimiento = $cilindro
                      ->seguimiento()
                      ->whereIn('evento', ['vacio', 'cliente'])->orderBy('fecha', 'asc')->orderBy('orden_seg', 'asc')->orderBy('orden', 'asc')->get()->map(function($item) {
                      $item->referencia;
                      if ($item->referencia) {
                        $item->referencia->doc_numero = fill_zeros($item->referencia->doc_numero);
                      }
                      return $item;
                    });
                    return response()->json($seguimiento);
                  } else {
                    return view('home.cilindros.seguimientotres', $data);
                    // return view('home.cilindros.seguimientotres', $data);
                  }
                } else {
                  echo 'cilindro no encontrado';
                }
                break;
              case 'cambio_temporal':

                $cilindro = Cilindro::find($id);
                if ($request->filled('accion')) {
                  if ($request->accion == 'registrar') {

                    $temp = new CilindroTemporal();
                    $temp->serie = $cilindro->serie;
                    $temp->codigo = $cilindro->serie;
                    $temp->situacion = $cilindro->situacion;
                    $temp->cargado = $cilindro->cargado;
                    $temp->defectuoso = $cilindro->defectuoso;
                    $temp->trasegada = $cilindro->trasegada;
                    $temp->evento = $cilindro->evento;
                    $temp->despacho_id_salida = $cilindro->despacho_id_salida;
                    $temp->recibo_id_entrada = $cilindro->recibo_id_entrada;
                    $temp->cilindro_id = $cilindro->cil_id;
                    $temp->motivo = $request->motivo;
                    $temp->save();



                    $cilindro->situacion = $request->situacion;
                    $cilindro->cargado = $request->cargado;
                    $cilindro->defectuoso = $request->defectuoso;
                    $cilindro->trasegada = $request->trasegada;
                    $cilindro->evento = $request->evento;
                    $cilindro->despacho_id_salida = $request->despacho_id_salida;
                    $cilindro->recibo_id_entrada = $request->recibo_id_entrada;
                    $cilindro->temporal_mode = '1';
                    $cilindro->save();

                    return redirect('home/cilindro/'.$cilindro->cil_id);
                  }

                  if ($request->accion == 'normalizar') {
                    $temp = $cilindro->temporal;

                    $cilindro->situacion = $temp->situacion;
                    $cilindro->cargado = $temp->cargado;
                    $cilindro->defectuoso = $temp->defectuoso;
                    $cilindro->trasegada = $temp->trasegada;
                    $cilindro->evento = $temp->evento;
                    $cilindro->despacho_id_salida = $temp->despacho_id_salida;
                    $cilindro->recibo_id_entrada = $temp->recibo_id_entrada;
                    $cilindro->temporal_mode = '0';
                    $cilindro->save();

                    $temp->delete();
                    return redirect('home/cilindro/'.$cilindro->cil_id);
                  }

                } else {
                  $data = [];

                  $data['cilindro'] = $cilindro;
                  // dd($cilindro->temporal);
                  $data['temporal'] = $cilindro->temporal;

                  return view('home.cilindros.cambio_temporal', $data);
                }
                break;
              case 'cambio':

                $cilindro = Cilindro::find($id);
                if ($request->filled('accion')) {
                  if ($request->accion == 'registrar') {

                    $temp = new CilindroTemporal();
                    $temp->serie = $cilindro->serie;
                    $temp->codigo = $cilindro->serie;
                    $temp->situacion = $cilindro->situacion;
                    $temp->cargado = $cilindro->cargado;
                    $temp->defectuoso = $cilindro->defectuoso;
                    $temp->trasegada = $cilindro->trasegada;
                    $temp->evento = $cilindro->evento;
                    $temp->despacho_id_salida = $cilindro->despacho_id_salida;
                    $temp->recibo_id_entrada = $cilindro->recibo_id_entrada;
                    $temp->cilindro_id = $cilindro->cil_id;
                    $temp->motivo = $request->motivo;
                    $temp->save();



                    $cilindro->situacion = $request->situacion;
                    $cilindro->cargado = $request->cargado;
                    $cilindro->defectuoso = $request->defectuoso;
                    $cilindro->trasegada = $request->trasegada;
                    $cilindro->evento = $request->evento;
                    $cilindro->despacho_id_salida = $request->despacho_id_salida;
                    $cilindro->recibo_id_entrada = $request->recibo_id_entrada;
                    // $cilindro->temporal_mode = '1';
                    $cilindro->save();

                    return redirect('home/cilindro/'.$cilindro->cil_id);
                  }

                  if ($request->accion == 'normalizar') {
                    $temp = $cilindro->temporal;

                    $cilindro->situacion = $temp->situacion;
                    $cilindro->cargado = $temp->cargado;
                    $cilindro->defectuoso = $temp->defectuoso;
                    $cilindro->trasegada = $temp->trasegada;
                    $cilindro->evento = $temp->evento;
                    $cilindro->despacho_id_salida = $temp->despacho_id_salida;
                    $cilindro->recibo_id_entrada = $temp->recibo_id_entrada;
                    $cilindro->temporal_mode = '0';
                    $cilindro->save();

                    $temp->delete();
                    return redirect('home/cilindro/'.$cilindro->cil_id);
                  }

                } else {
                  $data = [];

                  $data['cilindro'] = $cilindro;
                  // dd($cilindro->temporal);
                  $data['temporal'] = $cilindro->temporal;

                  return view('home.cilindros.cambio_temporal_b', $data);
                }
                break;
              default:
                $cilindro = Cilindro::find($id);
                break;
            }
            // dd($cilindro);
            if (isset($cilindro) && $cilindro && $modo == 'default') {
              $data['success'] = true;
              $data['cilindro'] = $cilindro;
              // DB::enableQueryLog();
              $evento = $cilindro->getUltimoEventoApp()->first();
              // dd($evento);
              $data['evento'] = $evento;
              $situacion = [];
              $situacion['observacion'] = '';
              $situacion['situacion'] = 'NO DEFINIDA';
              $situacion['fecha_desde'] = '';
              $situacion['mostrar'] = [];
              switch ($evento->evento) {
                case 'create':
                  $situacion['situacion'] = 'CILINDRO SE ACABA DE REGISTRAR';
                  $cilindro_temp = $evento->referencia;
                  $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $cilindro_temp->created_at)->format('Y-m-d h:i a');

                  $situacion['mostrar'] = [];
                  // dd($cilindro_temp);
                  break;
                case 'situacion':
                  $situacion['mensaje'] = 'perdido';
                  break;
                case 'carga':
                  $situacion['mensaje'] = 'perdido';
                  break;
                case 'trasegada':
                  $situacion['mensaje'] = 'perdido';
                  break;
                case 'vacio':
                  $recibo = $evento->referencia;
                  $cilindro_detalle = $recibo->detalles()->where('cilindro_id', $evento->cilindro_id)->first();
                  $situacion['situacion'] = 'CILINDRO LISTO PARA RECARGAR';
                  // $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $recibo->fecha_llegada)->format('Y-m-d h:i a');
                  $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $recibo->fecha_llegada)->format('d/m/Y');
                  // $situacion['recibo'] = $recibo->doc_nombre.', '.$recibo->doc_serie.'-'.fill_zeros($recibo->doc_numero);
                  $situacion['recibo'] = $recibo->documento->cne_attr.'-'.$recibo->doc_serie.'-'.fill_zeros($recibo->doc_numero);
                  $situacion['cliente'] = $recibo->origen->entidad->nombre;
                  $situacion['observacion'] = $recibo->observacion;
                  $situacion['observacion_detalle'] = $cilindro_detalle->observacion;
                  $situacion['mostrar'] = ['recibo', 'del_cliente', 'observacion_detalle'];
                  break;
                case 'cliente':
                case 'despacho':
                case 'transporte':
                  if ($evento->referencia_id) {

                    // DB::enableQueryLog();
                    $despacho = $evento->referencia;
                    $cilindro_detalle = $despacho->detalles()->where('cilindro_id', $evento->cilindro_id)->first();
                    if ($evento->evento == 'despacho') {
                      $situacion['situacion'] = 'CILINDRO LISTO PARA TRANSPORTAR';
                      // $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $despacho->created_at)->format('Y-m-d h:i a');
                      $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $evento->fecha_detalle)->format('d/m/Y');
                    }

                    if ($evento->evento == 'transporte') {
                      $situacion['situacion'] = 'CILINDRO EN TRANSPORTE';
                      // $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $despacho->fecha_salida)->format('Y-m-d h:i a');
                      $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $evento->fecha_detalle)->format('d/m/Y');
                    }

                    if ($evento->evento == 'cliente') {
                      $situacion['situacion'] = 'CILINDRO EN CLIENTE';
                      // $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $despacho->fecha_llegada)->format('Y-m-d h:i a');
                      $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $evento->fecha_detalle)->format('d/m/Y');

                    }
                    $situacion['guia'] = link_to(url('home/despacho/'.$despacho->des_id), $despacho->doc_nombre.', '.$despacho->doc_serie.'-'.fill_zeros($despacho->doc_numero), ['class' => 'none-text-decoration']);
                    // $situacion['guia'] = '<a href="'.url('home/despacho/'.$despacho->des_id).'">'.$despacho->doc_nombre.', '.$despacho->doc_serie.'-'.fill_zeros($despacho->doc_numero).'</a>';
                    $situacion['operador'] = $despacho->operador_nombre;
                    $situacion['observacion'] = $despacho->observacion;
                    $situacion['observacion_detalle'] = $cilindro_detalle->observacion;
                    $situacion['mostrar'] = ['guia', 'observacion_detalle'];
                  } else {
                      $situacion['situacion'] = 'CILINDRO EN CLIENTE';
                      $situacion['fecha_desde'] = $evento->fecha;
                      $situacion['observacion'] = 'ACTUALIZADO DESDE SITUACIÓN';
                      $situacion['observacion_detalle'] = strtoupper($evento->descripcion);
                      $situacion['mostrar'] = [ 'observacion_detalle'];
                  }

                  break;
                case 'cargando':
                  if ($evento->referencia_id != 0) {
                    $produccion = $evento->referencia;

                    $situacion['situacion'] = 'CILINDRO CARGANDO';
                    $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $produccion->entrada)->format('Y-m-d h:i a');
                    $situacion['sistema_lote'] = $produccion->sistema_lote.', '.$produccion->serie_lote.'-'.fill_zeros($produccion->numero_lote);
                    $situacion['operador'] = $produccion->operador_nombre;
                    $situacion['observacion'] = $produccion->observacion;
                    $situacion['mostrar'] = ['sistema', 'operador'];
                  }

                  break;
                case 'cargado':
                // dd($evento);
                  if ($evento->referencia_id != 0) {

                    $produccion = $evento->referencia;
                    $cilindro = $produccion->detalles()->where('cilindro_id', $evento->cilindro_id)->first();
                    if ($cilindro) {

                      $situacion['fecha_desde'] = Carbon::createFromFormat('Y-m-d H:i:s', $cilindro->salida)->format('Y-m-d h:i a');
                      $situacion['observacion_detalle'] = $cilindro->observacion;
                    }
                    $situacion['situacion'] = 'CILINDRO CARGADO';
                    $situacion['sistema_lote'] = $produccion->sistema_lote.', '.$produccion->serie_lote.'-'.fill_zeros($produccion->numero_lote);
                    $situacion['operador'] = $produccion->operador_nombre;
                    $situacion['observacion'] = $produccion->observacion;

                    $situacion['mostrar'] = ['sistema', 'operador', 'observacion_detalle'];
                  } else {

                    // if ($cilindro->origen == 'forzado') {
                      $situacion['situacion'] = 'CILINDRO CARGADO';
                      $situacion['fecha_desde'] = $evento->fecha;
                      $situacion['observacion'] = 'ACTUALIZADO DESDE SITUACIÓN';
                      $situacion['observacion_detalle'] = strtoupper($evento->descripcion);
                      $situacion['mostrar'] = [ 'observacion_detalle'];
                    // }
                  }

                  // dd($evento->referencia);

                  break;
              }

              // $query = DB::getQueryLog();
              // $data['query'] = $query;
              // dd($data);
              $data['situacion'] = $situacion;
              $data['titulo_pagina'] = $cilindro->serie;
              return view('home.cilindros.ver', $data);
            }


          }
          break;
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
        $data['edit'] = true;
        $data['id'] = $id;
        $data['cilindro'] = Cilindro::find($id);
        return view('home.cilindros.registro', $data);
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
      $cilindro = Cilindro::find($id);
      if ($request->filled('m') && $cilindro) {
        $res = ['success' => false, 'existe' => false];

        switch (request('m')) {
          case 'cambiar_situacion':
            $avanzar = true;
            $ubicacion = '';
            switch ($request->ubicacion) {
              case 'fabrica':
                // $ubicacion = '1';
                $ubicacion = Cilindro::getSituacion('fabrica');
                break;
              case 'cliente':
                $ubicacion = '3';
                break;
              case 'perdido':
                $ubicacion = '0';
                break;
              case 'iniciar_recibo':
                $avanzar = false;
                // dd($cilindro);
                DB::transaction(function () use ($cilindro, &$res, $ubicacion) {
                  $pre_evento = $cilindro->evento;
                  $cilindro->evento = 'cliente';
                  $cilindro->cargado = '2';//cargado
                  $cilindro->situacion = '3';//cliente
                  $cilindro->defectuoso = 0;
                  $cilindro->trasegada = 0;
                  $cilindro->despacho_id_salida = 0;
                  $cilindro->recibo_id_entrada = 0;
                  $cilindro->save();

                  //seguimiento
                  $seguimiento = new CilindroSeguimiento();
                  $seguimiento->cilindro_id = $cilindro->cil_id;
                  $seguimiento->evento = 'cliente';
                  $seguimiento->forzado = '1';
                  $seguimiento->descripcion = 'EN CLIENTE DESDE SITUACIÓN';
                  if (request('motivo') != '') {
                    $seguimiento->descripcion .= ', '.request('motivo');
                  }
                  $seguimiento->referencia_id = 0;
                  // $seguimiento->referencia_id = $cilindro->cil_id;
                  $seguimiento->origen = 'app';
                  $seguimiento->fecha = request('fecha').' '.request('hora');
                  $seguimiento->save();

                  $res['success'] = true;
                });
                break;
            }
            //situacion
            // dd($ubicacion);
            if ($avanzar) {
              switch ($request->situacion) {
                case 'trasegada':

                  break;
                case 'defectuosa':
                  break;
                case 'cargada':
                  // dd($cilindro);
                  DB::transaction(function () use ($cilindro, &$res, $ubicacion, $request) {
                    $pre_evento = $cilindro->evento;
                    if ($request->ubicacion == 'cliente')
                      $cilindro->evento = 'cliente';
                    if ($request->ubicacion == 'fabrica')
                      $cilindro->evento = 'cargado';
                    $cilindro->cargado = '2';
                    $cilindro->situacion = $ubicacion;
                    $cilindro->defectuoso = 0;
                    $cilindro->trasegada = 0;
                    $cilindro->despacho_id_salida = 0;
                    $cilindro->recibo_id_entrada = 0;
                    $cilindro->save();

                    //seguimiento

                    if ($request->ubicacion == 'cliente') {
                      $seguimiento = new CilindroSeguimiento();
                      $seguimiento->cilindro_id = $cilindro->cil_id;
                      $seguimiento->evento = 'cliente';
                      $seguimiento->forzado = '1';
                      $seguimiento->descripcion = 'EN CLIENTE DESDE SITUACIÓN';
                      if (request('motivo') != '') {
                        $seguimiento->descripcion .= ', '.request('motivo');
                      }
                      $seguimiento->referencia_id = 0;
                      // $seguimiento->referencia_id = $cilindro->cil_id;
                      $seguimiento->origen = 'app';
                      $seguimiento->fecha = request('fecha').' '.request('hora');
                      $seguimiento->fecha_detalle = request('fecha').' '.request('hora');
                      $seguimiento->save();
                    } else {
                      $seguimiento = new CilindroSeguimiento();
                      $seguimiento->cilindro_id = $cilindro->cil_id;
                      $seguimiento->evento = 'cargando';
                      $seguimiento->forzado = '1';
                      $seguimiento->descripcion = 'CARGANDO DESDE SITUACIÓN';
                      if (request('motivo') != '') {
                        $seguimiento->descripcion .= ', '.request('motivo');
                      }
                      $seguimiento->referencia_id = 0;
                      // $seguimiento->referencia_id = $cilindro->cil_id;
                      $seguimiento->origen = 'app';
                      $seguimiento->fecha = request('fecha').' '.request('hora');
                      $seguimiento->fecha_detalle = request('fecha').' '.request('hora');
                      $seguimiento->save();

                      //seguimiento
                      $seguimiento_b = new CilindroSeguimiento();
                      $seguimiento_b->cilindro_id = $cilindro->cil_id;
                      $seguimiento_b->evento = 'cargado';
                      $seguimiento_b->forzado = '1';
                      $seguimiento_b->descripcion = 'CARGADO DESDE SITUACIÓN';
                      if (request('motivo') != '') {
                        $seguimiento_b->descripcion .= ', '.request('motivo');
                      }
                      $seguimiento_b->referencia_id = 0;
                      // $seguimiento_b->referencia_id = $cilindro->cil_id;
                      $seguimiento_b->origen = 'app';
                      $seguimiento_b->fecha = request('fecha').' '.request('hora');
                      $seguimiento_b->fecha_detalle = request('fecha').' '.request('hora');
                      $seguimiento_b->save();
                    }

                    $res['success'] = true;
                  });



                  break;
                case 'vacio':

                  DB::transaction(function () use ($cilindro, &$res, $ubicacion) {
                    $pre_evento = $cilindro->evento;
                    $cilindro->evento = 'vacio';
                    $cilindro->cargado = '0';
                    $cilindro->situacion = $ubicacion;
                    $cilindro->defectuoso = 0;
                    $cilindro->trasegada = 0;
                    $cilindro->despacho_id_salida = 0;
                    $cilindro->recibo_id_entrada = 0;
                    $cilindro->save();

                    //seguimiento
                    $seguimiento = new CilindroSeguimiento();
                    $seguimiento->cilindro_id = $cilindro->cil_id;
                    $seguimiento->evento = 'vacio';
                    $seguimiento->forzado = '1';
                    $seguimiento->descripcion = 'VACIO DESDE SITUACIÓN';
                    if (request('motivo') != '') {
                      $seguimiento->descripcion .= ', '.request('motivo');
                    }
                    $seguimiento->referencia_id = 0;
                    // $seguimiento->referencia_id = $cilindro->cil_id;
                    $seguimiento->origen = 'app';
                    $seguimiento->fecha = request('fecha').' '.request('hora');
                    $seguimiento->fecha_detalle = request('fecha').' '.request('hora');
                    $seguimiento->save();

                    //seguimiento
                    // $seguimiento_b = new CilindroSeguimiento();
                    // $seguimiento_b->cilindro_id = $cilindro->cil_id;
                    // $seguimiento_b->evento = 'cargado';
                    // $seguimiento_b->forzado = '1';
                    // $seguimiento_b->descripcion = 'CARGADO DESDE SITUACIÓN';
                    // if (request('motivo') != '') {
                    //   $seguimiento_b->descripcion .= ', '.request('motivo');
                    // }
                    // $seguimiento_b->referencia_id = 0;
                    // // $seguimiento_b->referencia_id = $cilindro->cil_id;
                    // $seguimiento_b->origen = 'app';
                    // $seguimiento_b->fecha = request('fecha').' '.request('hora');
                    // $seguimiento_b->save();

                    $res['success'] = true;
                  });


                  break;
                case 'cliente':
                  break;
              }
            }
            break;
        }
        return response()->json($res);
      } else {

        $valida = $request->validate([
            'serie' => 'required',
            'capacidad' => 'required',
            'presion' => 'required',
            'tapa' => 'required',
            'propietario' => 'required',
        ]);

        $res = ['sucess' => false, 'existe' => false];
        $pre_cilindro = Cilindro::existeCodigo(request('propietario'), request('serie'));

        $procesa = false;
        if ($pre_cilindro == null) {
            $procesa = true;
        } else {
            if ($cilindro->cil_id == $pre_cilindro->cil_id)
                $procesa = true;
            else {
                $res['existe'] = true;
            }

        }
        if ($procesa) {

            if ($cilindro) {
                $res['success'] = true;
                $cilindro->propietario_id = request('propietario');
                $cilindro->serie = request('serie');
                $cilindro->capacidad = request('capacidad');
                $cilindro->presion = request('presion');
                $cilindro->tapa = request('tapa');
                $cilindro->save();

            }
            $res['data'] = $cilindro;
        }
        return response()->json($res);
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
