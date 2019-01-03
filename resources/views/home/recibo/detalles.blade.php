@extends('home.recibo')
@section('view')

    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Recibo - Detalles
          <div class="card-header-actions">
          </div>
        </div>
        {{-- <form class="form-horizontal" @submit.prevent="frmOnSubmit_frmRegistro" ref="frmRegistro"> --}}
        <div class="card-body">
          @if ($success)

            <div class="row">
              <div class="col-sm-10">
                {{-- <div class="card card-accent-success">

                    <div class="card-body"> --}}

                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="negocio">Guía :</label>
                        <div class="col-md-18">
                          <p class="form-control-static m-0 ">{{ $despacho->guia->negocio->nombre }}</p>
                          <p class="form-control-static m-0 ">{{ $despacho->documento->cne_attr.'-'.$despacho->doc_serie.'-'.fill_zeros($despacho->doc_numero) }}</p>
                        </div>
                      </div>

                     {{--  <div class="form-group row mb-1 mt-1">
                        <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="serie_comprobante">Serie :</label>
                        <div class="col-md-7">
                          <p class="form-control-static m-0 ">{{ $despacho->doc_serie }}</p>
                        </div>

                        <label class="col-md-5 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="numero_comprobante">Número :</label>
                        <div class="col-md-6">
                          <p class="form-control-static m-0 ">{{ fill_zeros($despacho->doc_numero) }}</p>
                        </div>
                      </div> --}}

                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="fecha_emision">Emisión :</label>
                        <div class="col-md-7">
                          <p class="form-control-static m-0 ">{{ $despacho->fecha_emision }}</p>
                        </div>

                        <label class="col-md-5 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="motivo">Motivo :</label>
                        <div class="col-md-6">
                          <p class="form-control-static m-0 ">{{ strtoupper($despacho->motivo) }}</p>
                        </div>
                      </div>

                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="referencia">Doc refer. :</label>
                        <div class="col-md-18">
                          <p class="form-control-static m-0 ">{{ $despacho->doc_referencia }}</p>
                        </div>
                      </div>
                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="observacion">Observación :</label>
                        <div class="col-md-18">
                          <p class="form-control-static m-0 ">{{ strtoupper($despacho->observacion) }}</p>
                        </div>
                      </div>

                    {{-- </div>
                </div> --}}
              </div>
              <div class="col-sm-10">
                {{-- <div class="card card-accent-success">

                    <div class="card-body"> --}}



                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-5 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="cliente">Cliente :</label>
                            <div class="col-md-19">
                              <p class="form-control-static m-0 ">{{ strtoupper($entidad->nombre) }}</p>
                            </div>
                          </div>



                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-5 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="direccion">Dirección :</label>
                            <div class="col-md-19">
                              <p class="form-control-static m-0 ">{{ strtoupper($entidad->direccion) }}</p>
                            </div>
                          </div>



                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-5 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="doc">{{ $entidad->documento->corto }} :</label>
                            <div class="col-md-19">
                              <p class="form-control-static m-0 ">{{ $entidad->numero }}</p>
                            </div>
                          </div>



                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-5 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="destino">Destino :</label>
                            <div class="col-md-19">
                              <p class="form-control-static m-0 ">{{ $despacho->destino_nombre }}</p>

                            </div>

                          </div>




                    {{-- </div>
                </div> --}}
              </div>
              <div class="col-sm-4">
                <div class="card card-accent-success m-0">

                    <div class="card-body p-0">
                      <p class="text-center">
                        {{-- <h5 class="text-center">CILINDROS</h3> --}}
                        <h3 class="text-center">{{ $despacho->total_cilindros }}</h1>
                        <h5 class="text-center">CILINDROS</h3>
                        <h3 class="text-center">{{ $despacho->total_cubicos }} m3</h1>
                      </p>
                    </div>
                </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-sm-24">
                <div class="card">
                    <div class="card-body">
                      <table class="table table-responsive-sm table-sm">
                        <thead>
                          <tr>
                            <th>CILINDRO</th>
                            <th>PROPIETARIO</th>
                            <th>M3</th>
                            <th>TAPA</th>
                            <th>OBSERVACIÓN</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($cilindros as $cil)
                            <tr >
                              <td><a href="{{ url('home/cilindro/'.$cil->cilindro->cil_id) }}" class="none-text-decoration">{{ $cil->cilindro_serie }}</a></td>
                              <td>{{ $cil->propietario_nombre }}</td>
                              <td>{{ $cil->des_cubico }}</td>
                              <td>{{ $cil->cilindro_tapa == '1' ? 'SI' : 'NO' }}</td>
                              <td>{{ strtoupper($cil->observacion) }}</td>
                            </tr>
                          @endforeach

                        </tbody>
                      </table>

                    </div>
                  </div>
              </div>
            </div>
          @else

            <div class="row">
              <div class="col-sm-24">
                <h3>ELEMENTO NO ENCONTRADO</h3>
              </div>
            </div>
          @endif








        </div>
        <div class="card-footer">
          <form class="form-horizontal"  @submit.prevent="frmOnSubmit_frmRegistro" id="frm_registro_despacho">

          @if ($success)
            <button class="btn btn-sm btn-primary" type="button" id="btn_print">
              <i class="fa fa-print"></i> Imprimir</button>
          @endif
            <a href="{{ url('home/recibo') }}" class="btn btn-sm btn-success" >
              <i class="fa fa-table"></i> Listar producción</a>
          </form>
        </div>

      </div>
    </div>
@endsection
@section('templates')



@endsection
@push('script')
<script type="text/javascript">
$('#btn_print').on('click', () => {
    window.print();
  })

</script>

{{-- <script src="{{ url('vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js') }}"></script> --}}
{{-- <script src="{{ url('js/home/despacho/registro.js') }}"></script> --}}
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush